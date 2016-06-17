<?php
    foreach($data as $i => $place) {
        echo $this->element('left_spot_item', array(
            'i' => $i,
            'place' => $place
        ));
    }
