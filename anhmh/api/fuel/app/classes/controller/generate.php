<?php

/**
 * <Generate - This is used to generate Model_ automatically from databases at basic level>
 *
 * @package Controller
 * @created 2014-11-19
 * @version 1.0
 * @author diennvt
 * @copyright Oceanize INC
 */
class Controller_Generate extends \Controller_App
{

    /**
     * <index - This is used to generate Model_ automatically from databases at basic level>   
     *
     * @created 2014-11-13
     * @updated 2014-11-14
     * @access public
     * @author diennvt 
     */
    public function action_index()
    {
        $host = 'sv4.evolable-asia.z-hosts.com';
        $user = 'journal_dev';
        $pass = 'journal_dev';
        $dbname = 'bremen';
        $option = ' --no-migration '; //will not create migration files
        $summary = '';

        $mysqli = new mysqli($host, $user, $pass, $dbname);
        $path = realpath(__DIR__ . '/../../../../');
        if ($mysqli->connect_errno)
        {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        else
        {
            $res = $mysqli->query("SHOW TABLES");
            while ($row = $res->fetch_array())
            {
                //d($row[0], true);
                $suffix_model = substr($row[0], -3);
                $model_name = $row[0];
                if ($suffix_model == 'ies')
                {
                    $model_name = str_replace('ies', 'y', $model_name);
                }
                else
                {
                    $model_name = substr($row[0], 0, -1);
                }
                $cmd = "php oil g model " . $model_name;
                $cols = $mysqli->query('SHOW COLUMNS FROM ' . $row[0]);
                while ($col = $cols->fetch_array())
                {
                    //d($col, true);
                    $cmd.= " {$col[0]}:string ";
                }
                $cmd = $cmd . $option;
                //d($cmd, true);

                chdir($path);
                $result = shell_exec($cmd);
                $summary[$model_name] = $result;
            }
            echo "******* DONE *******<br/>";
            foreach ($summary as $key => $info)
            {
                echo (strlen($info) == 1) ? "Model " . $key . " existed" : $info;
                echo "<br/>";
            }
        }
    }

    //need to search in IDE then copy/paste into a message.txt file.
    //need to create a current.txt file which content is defaul.po's content
    public function action_getlanguagelist()
    {
        $this->action_trim_firsttext();
        $this->action_trim_endtext();
        $this->action_rmduplicated();
        $this->action_compare();
    }
    
    public function action_trim_firsttext()
    {
        $file_read = fopen("D:\Work\Oceanize\Doc\messages.txt", "r");
        $file_write = fopen("D:\Work\Oceanize\Doc\output1.txt", "w");
        while (!feof($file_read))
        {
            $line = fgets($file_read);
            $pos = strpos($line, "__('") ? strpos($line, "__('"): strpos($line, "__(\"");
            if ($pos)
            {
                $pos = $pos + 4;
                $content = substr($line, $pos);
                fwrite($file_write, $content."\n");
            }
            
        }
        fclose($file_read);
        fclose($file_write);
        echo "******* DONE 1 *******<br/>";
    }
    public function action_trim_endtext()
    {
        $file_read = fopen("D:\Work\Oceanize\Doc\output1.txt", "r");
        $file_write = fopen("D:\Work\Oceanize\Doc\output2.txt", "w");
        while (!feof($file_read))
        {
            $line = fgets($file_read);
            if (strpos($line, "'"))
            {
                $content = strstr($line, "'", true);
            }elseif(strpos($line, '"')){
                $content = strstr($line, '"', true);
            }
            fwrite($file_write, $content."\n");
        }
        fclose($file_read);
        fclose($file_write);
        echo "******* DONE 2 *******<br/>";
    }
    
    public function action_rmduplicated()
    {
        $lines = file('D:\Work\Oceanize\Doc\output2.txt');
        $contents = array();
        foreach($lines as $line){
            $line = trim($line);
            if(!array_search($line, $contents)){
                $contents[] = $line;
            }
        }
        
        $file_write = fopen("D:\Work\Oceanize\Doc\output3.txt", "w");
        foreach($contents as $ct){
            $line = 'msgid "'.trim($ct).'"'."\n";
            $line = $line . 'msgstr "'.trim($ct).'"';
            fwrite($file_write, $line."\n\n");
        }
        
        fclose($file_write);
        echo "******* DONE 3 *******<br/>";
    }
    
    public function action_compare()
    {
        $lines_output3 = file('D:\Work\Oceanize\Doc\output3.txt');
        $lines_current = file('D:\Work\Oceanize\Doc\current.txt');
        
        foreach($lines_output3 as $k1=>$line1){
            if (strpos($line1,"msgid")=== false){
                unset($lines_output3[$k1]);
            }
        }
         //d($lines_output3, true);
        foreach($lines_current as $k2=>$line2){
            if (strpos($line2,"msgid") === false){
                unset($lines_current[$k2]);
            }
        }
        $file_write = fopen("D:\Work\Oceanize\Doc\output4.txt", "w");
        foreach($lines_output3 as $val1){
            foreach($lines_current as $val2){
                $found = false;
                if(trim($val1)===trim($val2)){
                    $found = true;
                    break;
                }
            }
            if($found == false){
                $line = $val1;
                $line = $line . str_replace("msgid", "msgstr", $val1);
              fwrite($file_write, $line."\n");
            }
        }
        
        fclose($file_write);
        echo "******* DONE 4 *******<br/>";
    }
    
    public function action_test()
    {
       $timestmp = strtotime('2015-03-15 9:36');
       echo $timestmp . "<br/>";
       
       echo date('Y-m-d h:i', $timestmp);
    }
}
