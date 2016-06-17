<?php

namespace Fuel\Tasks;

use Fuel\Core\Cli;
use Fuel\Core\Config;
use Fuel\Core\Package;

/**
 * Import data from Overpass
 *
 * @package             Tasks
 * @create              Jun 18 2015
 * @version             1.0
 * @author              Thai Lai
 * @run                 php oil refine overpass
 * @run                 FUEL_ENV=test php oil refine overpass
 * @run                 FUEL_ENV=production php oil refine overpass
 * @run                 nohup sudo FUEL_ENV=production php oil refine overpass > ~/overpass_log 2> ~/overpass_error < /dev/null &
 * @copyright           Oceanize INC
 */
class Overpass
{
    public static function run()
    {
        \LogLib::info('BEGIN [overpass] ' . date('Y-m-d H:i:s'), __METHOD__, array());
        Cli::write("BEGIN [overpass] " . date('Y-m-d H:i:s') . "\n\n PROCESSING . . . . ! \n");
        ini_set('memory_limit', '-1');
        $uploadConfig = Config::load('upload', true);        
        $files = array(            
            array(
                'name' => $uploadConfig['upload_dir'] . 'wheelchair_yes.json',
                'entrance_steps' => 0,
                'language_type' => 1,
            ),
            array(
                'name' => $uploadConfig['upload_dir'] . 'wheelchair_no.json',
                'entrance_steps' => 4,
                'language_type' => 1,
            ),               
            array(
                'name' => $uploadConfig['upload_dir'] . 'wheelchair_limited.json',
                'entrance_steps' => 1,
                'language_type' => 1,
            ),            
            array(
                'name' => $uploadConfig['upload_dir'] . 'amenity_toilets_and_wheelchair_yes.json',
                'entrance_steps' => 0,
                'count_wheelchair_wc' => 1,
                'language_type' => 1,
            ),
        );
        $license = '出典元(License)：Map data (c) OpenStreetMap contributors, ODbL';
        Package::load('gmap');
        $gMap = new \Gmap();     
        $result = array();
        foreach ($files as $file) {
            $filename = $file['name'];
            Cli::write("-> " . date('Y-m-d H:i:s') . " : Start ".$filename);
            $handle = fopen($filename, "r") or die("Unable to open file!");
            $txt = fread($handle, filesize($filename));
            fclose($handle);
            $data = json_decode($txt, true);
            if (!empty($data['elements'])) {   
                Cli::write("{$filename} = " . count($data['elements']) . PHP_EOL);
                foreach ($data['elements'] as $row) {                    
                    if (empty($row['lat']) || empty($row['lon'])) {                       
                        Cli::write('Invalid Place ' . $row['id'] . PHP_EOL);
                        \LogLib::warning('Invalid Place ' . $row['id'], __METHOD__);
                        continue;
                    } 
                    if (!empty($row['tags']['addr:full'])) {
                        $addr = $row['tags']['addr:full'];
                    } else {
                        $addr = array();
                        if (!empty($row['tags']['addr:country'])) {
                            $addr[] = $row['tags']['addr:country'];
                        }
                        if (!empty($row['tags']['addr:postcode'])) {
                            $addr[] = $row['tags']['addr:postcode'];
                        }
                        if (!empty($row['tags']['addr:province'])) {
                            $addr[] = $row['tags']['addr:province'];
                        }
                        if (!empty($row['tags']['addr:city'])) {
                            $addr[] = $row['tags']['addr:city'];
                        }
                        if (!empty($row['tags']['addr:suburb'])) {
                            $addr[] = $row['tags']['addr:suburb'];
                        }
                        if (!empty($row['tags']['addr:quarter'])) {
                            $addr[] = $row['tags']['addr:quarter'];
                        }
                        if (!empty($row['tags']['addr:street'])) {
                            $addr[] = $row['tags']['addr:street'];
                        }
                        if (!empty($row['tags']['addr:housenumber'])) {
                            $addr[] = $row['tags']['addr:housenumber'];
                        }
                        $addr = implode('', $addr);
                    }
                    if (empty($row['tags']['name'])) { 
                        $place_id = \Model_Place::add_update(array(
                            'language_type' => $file['language_type'],
                            'place_category_type_id' => '6',                           
                            'latitude' => $row['lat'],                           
                            'longitude' => $row['lon'],                           
                            'google_postal_code' => !empty($row['tags']['addr:postcode']) ? $row['tags']['addr:postcode'] : null,                           
                            'tel' => !empty($row['tags']['phone']) ? $row['tags']['phone'] : null,                           
                            'name' => '多目的トイレ',                           
                            'address' => !empty($addr) ? $addr : '',
                            'license' => $license
                        ));
                        Cli::write("No Name [{$row['id']}] <-> {$place_id}" . PHP_EOL);
                        continue;
                    }
                    $radius = 0;
                    try {
                        $found = false;
                        do {
                            $radius += 50;
                            $search = $gMap->search_place(array(
                                'location' => $row['lat'] . ',' . $row['lon'],
                                'radius' => $radius,
                                'keyword' => $row['tags']['name']
                            ));
                            if (!empty($search['results'][0])) {
                                $google_place_id = $search['results'][0]['place_id'];
                                $p = array(
                                    'google_place_id' => $google_place_id,
                                    'language_type' => $file['language_type'],
                                    'license' => $license
                                );
                                if (isset($file['entrance_steps'])) {
                                    $p['entrance_steps'] = $file['entrance_steps'];
                                }
                                if (isset($file['count_wheelchair_wc'])) {
                                    $p['count_wheelchair_wc'] = $file['count_wheelchair_wc'];
                                }
                                $place_id = \Model_Place::add_place_by_google_place_id($p);
                                Cli::write("{$google_place_id} [{$row['id']}] <-> {$place_id}" . PHP_EOL);
                                $found = true;
                            }                        
                        } while ($found == false && empty($search['results'][0]) && $radius <= 500); // find in radius from 50m to 500m
                        if ($found == false) {                            
                            $place_id = \Model_Place::add_update(array(
                                'language_type' => $file['language_type'],
                                'place_category_type_id' => '6',                           
                                'latitude' => $row['lat'],                           
                                'longitude' => $row['lon'],                           
                                'google_postal_code' => !empty($row['tags']['addr:postcode']) ? $row['tags']['addr:postcode'] : null,                           
                                'tel' => !empty($row['tags']['phone']) ? $row['tags']['phone'] : null,                           
                                'name' => $row['tags']['name'],                           
                                'address' => !empty($addr) ? $addr : '',
                                'license' => $license
                            ));
                            \LogLib::warning("Spot [{$row['id']}] not found on google map ", __METHOD__);
                            Cli::write("Not found on google map [{$row['id']}] <-> {$place_id}" . PHP_EOL);
                        }
                    } catch (\Exception $e) {
                        Cli::write($e->getMessage() . PHP_EOL);
                        \LogLib::warning('Ex', __METHOD__, $e->getMessage());
                    }
                }      
            } 
        }
        /*
        $result = \Model_Overpass::import();
        if (!empty($result)) {
            foreach ($result as $message) {
                Cli::write($message . PHP_EOL);
            }
        }
        * 
        */
        \LogLib::info('END [overpass] ' . date('Y-m-d H:i:s'), __METHOD__);
        Cli::write("END [overpass] " . date('Y-m-d H:i:s') . "\n");
    }

}
