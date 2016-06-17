<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>FuelPHP Framework</title>
    <?php echo Asset::css('bootstrap.css'); ?>
    <style>
        body {
            font-size: 20px;
            font-family:"?????? Pro W3", "Hiragino Kaku Gothic Pro",Osaka, "????", Meiryo, "?? ?????", "MS PGothic", sans-serif;
            color: #707070;
        }
        a {
            text-decoration: none;
        }
        ul,
        ul ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        #wrapper {
            width: 100%;
            margin: auto;
        }
        .menu {
            width: auto;
            height: auto;
        }
        .menu > li > a {
            border-bottom: 1px solid #33373d;
            -webkit-box-shadow: inset 0px 1px 0px 0px #878e98;
            -moz-box-shadow: inset 0px 1px 0px 0px #878e98;
            box-shadow: inset 0px 1px 0px 0px #878e98;
            width: 100%;
            height: 2.75em;
            line-height: 2.75em;
            text-indent: 2.75em;
            display: block;
            position: relative;
        }
    </style>
</head>
<body>
<div class="title">
    <?php echo $data[0]['title']; ?>
</div>
<div class="intro">
    <?php echo html_entity_decode($data[0]['content']); ?>
</div>
<!--<ul class="list-group">
    <?php /*for ($i = 1; $i < count($data); $i++) : */?>
        <li>
            <a href="./viewdetail/<?php /*echo $data[$i]['id']; */?>">
                <div class="help-title">
                    <?php /*echo $data[$i]['title'] */?>
                </div>
            </a>
            <span class="icon glyphicon glyphicon-menu-right" aria-hidden="true"></span>
        </li>
    <?php /*endfor; */?>
</ul>-->
<div id="wrapper">
    <ul class="menu">
        <li class="item1"><a href="#">Friends <span>340</span></a>
        </li>
        <li class="item2"><a href="#">Videos <span>147</span></a>
        </li>
        <li class="item3"><a href="#">Galleries <span>340</span></a>
        </li>
        <li class="item4"><a href="#">Podcasts <span>222</span></a>
        </li>
        <li class="item5"><a href="#">Robots <span>16</span></a>
        </li>
    </ul>
</div>
</body>
</html>

