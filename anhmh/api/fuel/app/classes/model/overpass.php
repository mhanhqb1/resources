<?php

/**
 * Any query in Model Place
 *
 * @package   Model
 * @created   2015-11-26
 * @version   1.0
 * @author    Thai Lai
 * @copyright Oceanize INC
 */
class Model_Overpass extends Model_Abstract
{
    protected static $_properties = array(
        
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events'          => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events'          => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );

    protected static $_table_name = 'places';

    /**
     * Import data from website http://overpass-turbo.eu/ 
     *
     * @author Thai Lai
     * @param array $param Input data
     * @return array List result
     */
    public static function import($param = array())
    {
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
            $handle = fopen($filename, "r") or die("Unable to open file!");
            $txt = fread($handle, filesize($filename));
            fclose($handle);
            $data = json_decode($txt, true);
            if (!empty($data['elements'])) {   
                $result[] = "{$filename} = " . count($data['elements']);               
                foreach ($data['elements'] as $row) {                    
                    if (empty($row['lat']) || empty($row['lon'])) {                       
                        $result[] = 'Invalid Place ' . $row['id'];
                        \LogLib::warning('Invalid Place ' . $row['id'], __METHOD__);
                        continue;
                    }     
                    if (empty($row['tags']['name'])) {                        
                        if (!empty($row['tags']['addr:full'])) {
                            $addr[] = $row['tags']['addr:full'];
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
                        $place_id = Model_Place::add_update(array(
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
                        $result[] = "No Name <-> {$place_id}";
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
                                $place_id = Model_Place::add_place_by_google_place_id($p);
                                $result[] = "{$google_place_id} <-> {$place_id}";
                                $found = true;
                            }                        
                        } while ($found == false && empty($search['results'][0]) && $radius <= 500); // find in radius from 50m to 500m
                        if ($found == false) {
                            \LogLib::warning("Spot {$row['id']} not found in google map ", __METHOD__);  
                        }
                    } catch (\Exception $e) {
                        \LogLib::warning('Ex', __METHOD__, $e->getMessage());
                        $result[] = 'EX: ' . $e->getMessage();
                    }
                }      
            } 
        }
        return $result;      
    }

}
