// Commont functions for map

var newSpotMarker;
var listenerClickAddSpot, listenerMoveNewSpotMarker;
var placeTypeFilter;
var markerOnClick;
var timeout;
var rad = function (x) {
    return x * Math.PI / 180;
};

var getDistance = function (p1, p2) {
    var R = 6378137; // Earth’s mean radius in meter
    var dLat = rad(p2.lat() - p1.lat());
    var dLong = rad(p2.lng() - p1.lng());
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(rad(p1.lat())) * Math.cos(rad(p2.lat())) *
            Math.sin(dLong / 2) * Math.sin(dLong / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    return d; // returns the distance in meter
};

// category icon
var imgMobility = new Image();
imgMobility.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAoCAYAAADt5povAAACuElEQVRYR+2XXUhTYRjH/+/O2bFtzubS+bWtD4QmK+zC9XljUQqBZIXHq4i2rJsQvOsqirqpi+g2aJMgSF14k4oglNCNSUEXBo1IYmfKhmFTm+bczhtnFSidc7aTcxDtuTk3z/P83uf//Hl5D/ELPEUBgxSB+VZbVVITswNlbJUmZmw1BBFpxRpVoLv0NA5ZLmoCPpn1Iikm/jHgQPRa1iktrB0tFdeRlwkDkc6sQKt+F9qr7haByMmlRUklR+XVNK/jj7O61MhYsd/clh+XpugqGMKBgMiC0zQJHWFBoNs88KDlAp7OXsEe4zEctlySBQaj3ajk6tFs7d48ULpL3y0+g63EhdqSfbLAqaUhlLHVcBqa8gPMusB1CXm52goGZIg+Y5bdn+ZxdHwaKT2DD24b6C/vGBNrqA99wYqJw2jbXiRKS5AUlwEoP5Oyvmmcn7/ixOhHxMsNeN9Y/cewXDKNpgkByyYOI2cakCjlVAVRBdYJCzg1HEK0tgzCTotqo8a3M/hu0GOkvSHzVQpFYM3MIlqGQxlxYjVmpFmdKtC0lET5/DIWLNswfM6NJMfI5ssCmZQIz4QAnUgxecSJlF4d9rtzZewbXFMxzFWbM7uWi6w71OLQXHL/A2BvpONALlJIOSIlYwAq1ucT0EFCcDvXHvLXv0K1X+AHAZzdCCRdXkf/oy0BBiJ8D6W4v6G5jrp8dcHQlgB7w50ekdDJdc3nfI4Bef8rnECTpDdpM+uI2OIATFI/aX9eR/B8rtP9rNEY/jA/BoKTmTJCenz2/gdaWmgGBoSOGxTkVgZCdR6fs+/NlgL9Ef44KF4ASJjtdDtPgsr/ZjIn0Tzhw9k2I5s2xAH60ucItmqZ7q92KBX5hY4JSsnQZefAnQIBO++JICNdjr7xggADYb51jV15dbX2ufSe0BQ/AI48b4zV18kvAAAAAElFTkSuQmCC';

var imgCar = new Image();
imgCar.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAoCAYAAADt5povAAACrklEQVRYR+2Xy08TURTGvzvDtKWW2KY0vJWCUVEjVTFirZpKfCwwIfwBgAtj3Jqw0YXGpboxbGRV6z9gEHGFwZg+DDbIoICBChofJNhWikAp0F4zE5tUpZ2Z2jYselczmXO/3znfuffmDnG6eYo8DlIAZtvtgqXZdhRbz1KGELQd3gOdWiVZbd/oFMIrq2njJCvcXW5Ec10VvB++YHV9I6VYc301Aj9XMPT+Y+ZAlmHQfmSvLKGGilIcNVdiYGwawaVISmjaCvdVmtBUW4Gn/DRCy6lFBPVEcj+WIxicmFUGLNGoYNAW4/iuatHGkU9zkv0TAupMBuw0bsfw7FcEliKiM3+PTStM2COLkiLoc2hx035KAqMbMaiLWFnsjVgchBCwDEFGwIlvAdFOYeFoVZwktH90Clo1h5YGc2ZAYU/NBBZgqSkTM5ca/vkQOJYV+5hRhVKAdN8VASv1JTCX6lEUW8W2yHdRN6yrScvXRebBxqJY43SIqA3iNpqcC8hbpYmo8uBbnPPeEF8ftT5JCzzvvY6y4DtMmi/i9f7LyvZhItoY9sPK94iv/afupwVax3pgXPBjpuo0xuvbMwP+Tw9TzZU8vLMNLQCz7egWvGJku0Ti8L6plSvKxJkRAIY/4il5HGdj1+RqSJ/ISUpON98PoDVZnFB6tcNmeZAboIvvBsGdZHFK6YEum2U8J0CHi29mCLxJ4sEO60ETIUT2L58iS3t9Pk4T5cIAin9D+zpPNLbJrU6IUwQUJjjd/HMAZ4RnStDdZW28l2vgLQA3RQihxzqtluGcAh96+BZCMQiC5R3RkN5ut6e+jm+SiWJLe30+rSbKLYJiqNPWeFZJdRn1UOyjh39F4vRZh81yOz9AF383TuMDl04eepEXoMPDX1hTrb+80tT0711eIoNf50VFdUpaM/MAAAAASUVORK5CYII=';
var imgLeisure = new Image();
imgLeisure.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAoCAYAAADt5povAAAFQElEQVRYR+2We1BUVRzHP/cuKwtiCyqKKOSIChaKyvosy0bTQocmzAjrD4VqUotRccqyKRVtUsTJGnOmhvVVvrJsTGCm1ziagsoOYqgQ+EIEeYjKAvJY9jT3rqLLw92bU391/ru/8/39Pud3fufc85Pic4TgPxzS/8D2u23UQ1wQ6CXYVQrVTdrq4faWSggG1pwm7lEdIUPDVcrVy3+xvbCW8z1HIyTZLfIDgYEGGG6ExvMnmZq1HL/bZdyKTiEg8nk1eOXZo/jsXUCd3pefx62kW9hkzlmhpKFrdpfA7h6wLhwMOqDRyg/pP/JL0GzQG1iky8ZT2EgVT9LUYuPpku+YM30akk8vbAKW5cON5s6hXQIDDLDm8XtOH+QLKpok1fDC2c/wbqllV8RH6rePB2yMuKddUwAX6jUC+9cWskJ/lEbTHOTcfWSfOcc3o1YjkDoAZxRsYmagTMuEeXidSWdddTBFvcd0SuwywwXZ87lp6MvOkSvoU3eJdw+/Ql6/KSo0+uzGtgyjCjczvehrUibtpNQYpi4mtDqbdU/tdh/oaatn48HRrJySQXmPENXxfmitZ2+8W6zcMvg7wRSdsbGS9RkTSJpxHEXXfnTIUKnH4iArwXIdm67349TNey53oTq7jVbZA729uS2zu6phPWCRfxlVwpvUUl9utDgjOwCn9YXYAQ5Rc81VLm5b4uThe7uSvnUXVVt19yCuewc6zQfHJuMVOFS1HSyH/WUugBFGSBzsEF2qqOLgiVwnj6nFWwirylJtF3tGkB660Gn+2VHhhA5wLCLtEhy77gKoTD+jLyOudCtLApZSJ7q1eSgHZFb+WqcImaHz2Rf+XpvNU7KzoXwtmf1nk946mPZPUaenVBJ2UjIn8u3IVeQGTlODKbCowk00evTAu+UWINGs88QmdyM7+MU2aGhVNu9kvcGimRZ1zuWhuStQ7ta4G8c4GLWD/qe2MyVvPTtGfUJCzhKOBc9CJ2yYSjMwm1KIPb0ay5A4iscmMvX3RC7o+rJnxIcdYIqhy3v4iGggNew2sk8vRG0lKTnXiLj8E/71JZQah6n3sFtrA7JoJTNsIcnhOuSeQYhGK8vz7VRIRm3AQC9IfuyeT3JePUn7J/Ll+M2EVp/E22blj6AY3j8Uw6roLFaP8WsTf1oIRXWd8rrOUPlrvjUIIv2gseAI9j2JKM3ItphfeTPMB1mSSCtuJOb7KLxsdcjRq/AaHU1+LXxeDK1dNC4u30NZIdttrM2cpL55vaIWw+iXHMsv+I3qfR+r25s04wQ2DwN2Fx2SS6ASd1DNKZYeeZWkqOOM76PntUGeKu9ASTPpFRLrM8aRZtrAnwGTO9/H+6xuARNykmjWGdgxao3qGtId9DIUWB2RYs6kEHTzHBufMD880KephtSM8VzxHcZNQ59OA/ZoukHIdQvLnjus/u4eNFxmGGC9wPCKQy5XrpbUfwJXjMMeDugWSYPIZYYaYrkl/e+Bc3PFQLeWBsitHACGO+klTtplXnY3hqMNc3PMs4gvJMHb7eRrzSZpmZsh0ARMyBGzBey9P7gEM9NMUvq/Apx7QgTIMuX3BRce4PeVSVIeSLeGpgyViPE5ogi404SQZzZJI90i3RFpBs6ziDRJEK/6CzaZx0jta/rgi69ldWqGFjEXwRbVTyLWHCk51dRVPM0ZJljEYCFQthW7nX5bx0rXXEHaHTItcoc2Pkco3Wa92SQN0eqtOUMFkHBS7BbQYB4jOWqpYfwjYLxFKN1vvTlS2qqBdafsWj2A1y1ihJJhWqRUrNX9bwTpLmWsjPqAAAAAAElFTkSuQmCC';

var imgFood = new Image();
imgFood.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAoCAYAAADt5povAAACEElEQVRYR+2WwUsUURzHP791BUFRUlhLRQPd7KIU4kUQ/4EFUfa9Dl2ia/0B/QudpWPUzZjxYhB0WAi7ehAvHkoJQdpOoqArKO6L2RnR1cZ5s87UEg4M7/Kb34ff5/seb8S4ruEvPnILTNp2kynN52FnBwYG/LWvD7a2/jx0JgO5HBwfw+5uqJjrJywWYWUFZmb8dWoKlpevNmtvh+lp6OiAjQ3/DXmSAXqw3l4fkTpQBObmwFOaCNDLbHjYz25w8KrS1laYnT0XeOMJL2ZxcvK/AQsFaGs7n3FvD0ql+v2XqNLOTpiYgJ4eKJdhbQ0qlRSBXuvJSRgaCt/uiU7YlMCWFhgdhf5+6Oq64cG3mfAs0Sj1QV30bWHZKDLr5gWOPYBcN2yXYXM7/D62rItWelCCb59h/ClkH4cDLeuigUdf4ccXeDgPmbFwoGVdNDDhn5pbYMJC4R8oXVy8bz1GNvsRqN+qxqxyeqpte4htoVdnlpYWMOblpW9ei1KvbPvEA7quApy65sYUROtP6QAd5y4i5QvNDcbcEa33UwHWtLrud2CkBjBmXbR+ZAvz6mIpDYBvgecB5I0odTnTa/nxgY7zDJF3ta4iT6RYrM80YtxGgCOIeFo9pfdE61+pKg20/gQORal8HFhDGQbn8QPGVESpsyytubGVBsAXVKuHovV7a1JQ2ChwnGq1IlpvxgX+BhPiSdUvXmcPAAAAAElFTkSuQmCC';

var imgLife = new Image();
imgLife.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAoCAYAAADt5povAAACsklEQVRYR+2XX0hTURzHv+fOObXS7O8ci9mL7qGsqNzqIVp/UMRFrz2EE2rLxwrfgiR66Q/06OYeNqGgN4ll9FDNVqKbJi4ZTqU/VJtrZLrNdLXdnbg3EJcL7nV/MPA+XTi/8/2c7/d3zrlcYnTbKQr4kHVgrtP+PyJlaArFbALxIhkfQGkijtpvH/n3iW3VWJSW/DMY0Q4V0TAMIz2oiMfwYL8eb+W12BUJ4Zqzk4fc1LXhc4U8e6AkxaJp0oXGyVcoSrFLgh5lHfpVB3C5vzt3QM4B50oZCWVceUIihZRNZA8sSiXR7H+JhqnX4Pom5Ll17CLeb1GKj1Q1F4ThTQ8UsbAQzlLNfHEZHtY1YUi5N+O8FZtGyiZxZvwFTr0bEOwqk7K3So37+/SIlmxMG04Dcn3Q+/tQtTiHyhqdKGd/F89/8eL7z3k41DrMlpYvDWc8FmWSYtw7eC4rYOeUE6Ozn1ZorH2gKzwJV3iCX7lqw1ac3300YxI5c/g44IUjMMpDasrluKpuyC/waXAM49Fp+KPThQH2BrxwfvUjlowXBljwSH2RIHyRAN+3HbJNOL5TnX0PpYwEjVWZryahh3No5gNC8YiwcyhUdDV1oj/Aq4Esn7MOzDbBNbBpLg3YqoXaSDFkBEBl2iYAekiKXhGqQYQWcnUmt91BgeZ0IG2zaFrNQnVEAY1uWztAbi8XpwR7rPUGX16AFwZtWoaQgWXiM131LdtBiOBfPnEOhy1SsDLuvirloBT0kVXTelaoO65OFPBPH7ufU9ATPJCi3ao13M0r0Oi2dQDkOgdhGKIxH27x5BVo8thPUopnAH4oFlSbO3S6ZF6BxmFLGVhZFBTOLq3htBjYqnrITTK6bYOUkidWreFGQYAmj/0OYWmv+UhrX4GAtkbK/HJ1HTItiAX+BupgYa5mmdTeAAAAAElFTkSuQmCC';

var imgPublic = new Image();
imgPublic.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAoCAYAAADt5povAAADAElEQVRYR+2VW0gUURzGvzOzk7umWCRmRpi0hmGpRVCSBYUQQWKurEEUrYEUZEL10lNBbz6UD13opWalHkzZhRIJg4qyGxphF8layUqypawU2x33cvbEzKY4uuvOeCmCPU8L5/v/f/P/znfOEotdYviLi8SBs+32/2HpikUcjALQ5Q7pNkDXhARASa4Be9cZwBHA8SqIxs4gqI6cawamGAlqNgsoyOCAD+1AwAeYi9D9jaHuQQADHm1UTcD8DA41RQIWmAjwpB5oPhW2clsNUHwMHj/DxcdBPP1IY1o8JZDngD1rDShdbYBsp7IajgAvm8O/szYAVdfHILffUYjtAfin4EYFLk4mOLpFQHYqp/5qVxtwrQqgQaCiDsgrUe33DTKcve/Hp8HIFkcEFmXxOFQowCREccjvBVgISEiKKAhQQOwIoPXt5FEnAVPnE2zM5GHN5/HDC9xxUWSnEsgfcaubwj3MUJrLK6AbXRTpyQQ7cng87KVwDaj3nn+m6B9STxrV0kvlCej9yVB714+tZh7VmwScbPUrd+9MSYICPN7sQ246h9Pb5+H8owDu9VDVXqTx48C4pTMPzao0DsUreRRm8hj2Mbx2h5To56Rx6OwPYVBiWL8s/Bg86wspz538vnZ/DSlXZvyerG97r76Lk1I6egViPooaBC1vKK60B1TKfw+ULVqaMvZUa5gjuuS7hyk2j1+a/p5mRJ1QHAfOpptKr79v6S5RWq51DJ7gJgPWTNB3hBgqtPbQlX+L3XsOINWqmDNS66g0npgTYJnotRJCGtXNyU6nzdgyJ0Cr+CudEv7LuOaM9xkXNh0kQ3MClJta7JILgDkcOfbCuT+xQCtMKdEjlrVl9dJlwnAgXMwuOGyJqjON1U830CJKNhCIf4C7HbbECWc6NVI30Hp1xEwpk20Fz+iSpsokd6ypVKnWIx7VWuxSPwCP02bK1luve0IlOKLUAAKv02ZSzlLPmhawzD5ymDDmcVaa7Hpg00qpXFRe78vjOOZt2mfs0Qv8DTjsyJ5JCK7YAAAAAElFTkSuQmCC';

var imgCategoryEmpty = new Image();
imgCategoryEmpty.src = 'data:image/png;base64,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';

var imgWellness = new Image();
imgWellness.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAoCAYAAADt5povAAACd0lEQVRYR+2WzWsTQRjGf5Omnzahn7bRKmqTBbFaFUHwIB704AeJILZX8eJBT+LBf8GzeBKpIIJ4qS0Ur4pSrAqSg7QmFaGWxpSmbRKT9CsdSWalJtJkd02Ch8xpWN55fjPP8+7sCjkSkFRwiCqw1G5XLVWOtjbACVdhdz+GYGmlaALGLO1ohFM9hcXGZ2EhVSbgxFOIh+Hs7S1A2YDjQ/DuCayn4PgVOHdHQS0DawTYRK41bY1wcpd6FnwDbx9CKgqnb0DfBfV8Yg4W8yzdlJDOvcj+zrCvEw60FM4i8BpSy9DvK1z3PQafwjk11oBFW0Mv+P+B80mYXoT+LthRC1MRiK5u5ZnJrb0R3K2QWAd/GNxtsLNJHdH0CUM/4fOCAjjqwD+vXu4ze5XgqxnobIJDHRBfU42TmbuaLQKNZrVdnekTVhz4e4cZC5318D4EkSSc71VbefkVupvhWBfEVpXFmfkep0VLl1dgNq6aosEOMzHVHAfbleBkBJx1sNsBKxswvQQ9DmhpsAisuKUVAWasq6/5V5Rav5aG1EaRq600qG1VjH2AS7iJKrCEZiopIYcn9xlWtdlHQR7Oq//AZnrAqEbev0ThZXIkeB/krZwqyT1xWbtbLuBVkM/zxC8JnzZWHuDYt2421kN/iEtWa1rFQG+0LMCMqBwJBAG3DvALn3bUKCzbNGaKdeAj4Lrecw+Ez5ObaRFB88DRwDUkQ6rHxaDwevIzLYg0DxwO9mKT01lVe61LXNz/w4xLpoG6rXNAQvg0jxmYpQyzwNHgM5BJ4dX0LI1jrZ3wxZeb2ERCeLXHxlF6m5ldoCydOgL2pPC5VZYmxi9SYz/ZNGZhvgAAAABJRU5ErkJggg==';

var imgShop = new Image();
imgShop.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAoCAYAAADt5povAAACVUlEQVRYR+2XS2gTURSGvzNJbJqqsViT2pC4kip0IaLQhRWsSosLQcSNoBSkbqVbFwWpKykiiLgRXwuXQfGBGGwrQhF1bS0+wKTUDnFRH43VJDMyTUMySZWZTiYu2gvDDHfOPd+c/9xzuCN6MqxTxyGrwFqrvVIlzQjkHYqpAE3VBVAtaQ645YffDoFeoG8efGY/1cD3HkhUWC2X3Z2FdrNU1cCHayBp6FGDEdHgsFkqM9DI3e0GqGXvOfEL1pYcmoETHhhblFNRQNOgeDcCLn8WBfSK90vNdWWhoySrGfhD4IkPmndC+zEYvw5dp+HtU/iehj2nYOQybN0LXh+8SUD3GRi/AYFm6OiFZ1eh8yR8vA/pl3AwC+v/FmExbS03obHXWRJ/PoYvfVU+lu40/x34bRi+Dpu/VglCZBJSrYX5DUOwrr9k4yjCugNzHyD7rqJl+MC/36UIM/cgc7cCGICNV1wC1l3S+VEwrvIhfgiehdnBwmzjIWjoXOamaToOvu3O6jA7AXN3LNahM9Q/V6/UI8aqpA4UEH1q0w7L6zUlAbRUFGQcJT9k1YdYNTTs9GQ4DhwxNwD6Japes+rHLnAAuGhy7vFsk8j0pEvAzbtAe1XmPC0xNWQVZtjZi1DHSyo8a5ypCxCJS2zmqGvAxTwaG+fAAkRnQLaol9wFpkKD6HKuAFF2S+zza3eBU6370PQRYI6oGhSx99tjK4cLKk63BcjljTyOSkztsROd7U1TdK4nwy+ABxJTz9cH+Cl0AUV5JNGZsfoAk6EevN7n0jadsQv8A70EHWRdSwcNAAAAAElFTkSuQmCC';

// rating icon
var imgRating0 = new Image();
imgRating0.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAGCAYAAACvkeyYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3MTc3ODBDQzVGMjA2ODExOEMxNEM4NDA0RDVEMkI1QSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCMTUxMTZDRTgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCMTUxMTZDRDgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz67xwTgAAAB10lEQVR42kySy0ocQRSGT7UaAtm4EdRgDCEKMRDRTBxUFBFiFvoA5oF0Y3Z5iLg0y2QTjJsJqIMKIo7XIDLjJYOg442ZzvdPnxYLvv6r/nPq9OnqsjiOB2u12gwcwzV8h0n8Z2DwAmbx9qEI8/AJL3i8B+bwtuEcFliPecxY98IXOIJL7ccfSfezfgtfoQwVvG/wuZHHFEyYWZsSGQMhhAN0Ez3U2gu99PhQiKKtYLbM/By68Eehy5LxAbLsXcW7Zp5Bx9HnCuJnkTW8AnqHDsMQ82ZiSslARY1Nw6v6F2qjWSu7x1F1fq9G9FK+pn4CbO4g1ktuO3pFvBP/jeL+4hbkPXTj76L9aF+1WlXMoihqhRH8XxS8QD/W4vhdzH58i0J4TeJTNDR5p2lhBTUREVZD0q+lhaURRqPHHoafqEaTCMmI/ZeZmtMvtGRvUH3iT1QrzYmT9zToxT+gkDaEXkKe5DKUiG2Y5klMXODv4xUtObFTvJO0cUYV3YE9qLj+fRQvwzrzEugq/EELjw7nDFbV2E/MnBfRr1uh+0VPuKXaurx6QyH809yS+1XyQrqPy8SKXmPDcxS/0X3C+81Jn/iH7eHlOTp9jOrlvNE7cm51KKyX/gswAOwXQ9KkRzKXAAAAAElFTkSuQmCC';

var imgRating1 = new Image();
imgRating1.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAGCAYAAACvkeyYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3MTc3ODBDQzVGMjA2ODExOEMxNEM4NDA0RDVEMkI1QSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCMDQ3MDJCRDgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCMDQ3MDJCQzgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz68SopIAAABjUlEQVR42qySz0rDQBDGJyHZNK1tvQleBA/6Cl59AkHRiz2IKD6DL6APUDxoRZDWehLEF+gTeLc3e/NisYW4zZ9m/SbZRUlFFFz42tn5zWRmdpfU8VIZakESCqEOVCe9lFJlqAVJKITaUJFf/sDr0K1mHHPBOQXe+cK5VtkBa1Kptm8CaX5xl16efFhb2tOEPjlRAypB23p/liq1Z1tWtknTtGHbtgdzR/Nr+Dbgy7lSh4hVMI80v0qSZNNxnGwTRtGBJ4Rt8UnR6nqJBo8oVyVaWCHq91LEVOnkWeJfItHjD6MATSEk5pxowjyKIuG6Lk9PcZIYPge50FsYhhZzC83HcUxCiHfYFcRXwMdBENie5xHXQCz5vj/Jx+j3UGJM5Ndzu7B4Gk7STc1wFMqL5k3NcC7KjGPENxyNZN82sby4sW5mLa8homZi763TAU/FR37DDiklpdOp4XdgzFOTjysocglhWnpgx3g0otfh0PA2/4AHXCu7YuTyaekr79I/Pf7WHx7/+W8e/4cAAwBM3EzMZRufgwAAAABJRU5ErkJggg==';

var imgRating2 = new Image();
imgRating2.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAGCAYAAACvkeyYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3MTc3ODBDQzVGMjA2ODExOEMxNEM4NDA0RDVEMkI1QSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCMDQ3MDJCOTgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCMDQ3MDJCODgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4h3qImAAABw0lEQVR42nSSy0rDQBSGz4Q2aby7KIIIggt9Bbc+gVDRTQtKERFURHe+gK5VBFeCoi4UQXyBbt2ICFLsRiwIdeOlhTZtmk78T2ZqU6sDf3JmvpOcyxzhb412EdEulIIM6BJaETv5It70B7+AVn+47zPfg5JtXIgm78frEEpAEjqBNsArIX4AzWp+Cq1H8NinWF+ammtgOElvTzasGX2yD7W4SjCmf8TrQPr+giFEsJFSpgzDsGDOaX6Ms2mcKe77S/D1YS5rfuR5XiISiQSbmusuWqZpCHTEoYmpGOXvEK6XaGicKJfhzLEhJ9DgiEVOSXEbBRayim+/VJm7rmtGo1GunuqeR/gx8x4oCn3VajXBHF2ier1OpmlWYHfDvxu8VC6XDcuyiJOHL9m2XVVl5DJE1ZIKyvbv9fna4oVsB0YgFVQl1cE5KDP2MRV/DHMkQg0pf3xJz8R5YI1NwqOv6XuNGapA3PKzP/hVwIWQze9xBSQbjRYXwoFQDd3wQalYpPePDzbvtTjRMscKrhjfcrf0lZ/zxa4FQ/d82zb8oYJ+82C4Q5x9PXTqPz7Pwx+Px3n4H3RSmyGeRjIOutY2/N8CDADKhbiMNAz0hwAAAABJRU5ErkJggg==';

var imgRating3 = new Image();
imgRating3.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAGCAYAAACvkeyYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3MTc3ODBDQzVGMjA2ODExOEMxNEM4NDA0RDVEMkI1QSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCMDQ3MDJCNTgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCMDQ3MDJCNDgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7E6GycAAABxUlEQVR42oySz0obURTGvztkZjKJjboIQikUXDSv4LZPIFjsxoASxC5sKV32BXRdRHAl9I8uWiriC7jtxm0wGzUgqIukJjAZk5nM+J2bGROTCA58c//8zsw5595PRV9fZwB8o4qUQf2h1tVmtcERY/hv6uOzeRRNctihFqiQ+kF9UUq1Bvg2tRjzX9TnFF9bSOdKSJ6pl0u4PnU4exfvbFF93isgHf8I+qdWZgW+J1kAK1tEx7W5/z7m38MwnDcMQy/CKFozlJLph5jvBkGwkEql9KLd6azalmUoduyh8DaN6gnTvQBm3gCVY6k8R0lXHqZf2fCaPe6wwauycC5wp/lMwULtHDAz0ljCJ7BxYXK8bbfbyjRN8JTg+z4sy2pxnuVpZcmbrusatm1DimcsHMe567VROWaKZi+pzIef/5d9flUe5TcVIOgkRY1gSeoHgS6MRY1wFoJuGD7EIvbEvp7NzjEil8Qe0iMuxbvB3hh+QNaiwie+/0vmsRB2gyPZaDYaqNXrCRcfSaGu5NJX3O3q04qvfF8u9pM23dm/R+YfaGiYa3MPcIntki89wZfF/Pl8PjH/TzH/AC+xGI+n9sj89wIMAHAFsi0jwXUqAAAAAElFTkSuQmCC';

var imgRating4 = new Image();
imgRating4.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAGCAYAAACvkeyYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3MTc3ODBDQzVGMjA2ODExOEMxNEM4NDA0RDVEMkI1QSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpBRkIzNzA3RTgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpBRkIzNzA3RDgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4jaUnzAAABxElEQVR42nSSTS/EUBSG3zajnc74XIlBJBYk4gfYWllKRtgQRIgFQmzwC6wRiZXE54II8QdsbexETCRkQnwlvibpdFqdjvfeaRkzNHnb0/vc3vOe06PkFpoiAJaoAUql9qkJZTH5wSf+4HvUZBFfpvr/4VV8rFFxyqO2qBnytOS5nOCrVK/Pt6npEG8rCFeOILiqY/14vDQY9fgrK9QPzxsM+wdBHqpFhvFpiSyAFh2AY+pc7/P5Bte6uQYoClBmjMFJcyPGfb7uum48FArJF9txRnVNUxVWZKG1M4zkGdNVALUtQOJEOOcLLKmaBh1WKs8NFvhwEfCM5LWtGl5umDQiCgt4OVVGvSPWruD1FsjaQE0j8HyVZsei7FaUPGWapqrrOlRVhW3bMAwjo0qbiROmSOWTirj4erv74Q8XpfwpAbhOYKqU35/TUD3wmRGmSjCNIOt5MhYG4c/EroyaO7ijMth7JGaAEi3f+YMf+Nz7/r6urZhbFKvBMRSm6RgEuuYCLuaMf1YxRS4Re9ms7JbomjhT/NgpOXTXp7+Gv6CgYi6Hu4CLvS479R8fQs5bw+F8MPyb1GwBH6EZi137NfxfAgwAGwWzsHX/Vk0AAAAASUVORK5CYII=';

var imgRating5 = new Image();
imgRating5.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAGCAYAAACvkeyYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3MTc3ODBDQzVGMjA2ODExOEMxNEM4NDA0RDVEMkI1QSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpBRkIzNzA3QTgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpBRkIzNzA3OTgxRTMxMUU1Qjc0REIxODUwNjcxMDQ1QiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NzE3NzgwQ0M1RjIwNjgxMThDMTRDODQwNEQ1RDJCNUEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7lTI/0AAABuklEQVR42nSSSy9DQRiG39PondJV06pILDRp/ABbG5aSCpsKIsQCITb4BdY0EiuJ64II8Qe67caORiOpCFEkbpX2VFutd+acQ7V1kvfMzPfMfLd8Snm53QFglRqmTNQhNa2s3LxzRR1+QM1U8TUq/A9v5rJBhagStUPNk2cr+Do1qPNdaq6BvwhsrnEYX4svjIdLO3cDuiVC/XItQZvuCNKpxTGGgsooZcDiHEY+Y6V9SOdbtPXTBigKYLZPIp/lRUzpfBNufwivd9rJG5xAKm5SmLGKQI8NN2cM1wR4OoFEVGTOA1Qpt98KNa1xOwtMxQ2ek9wTsOD5mkEdojCDN1Jm6g2+LgUvt8DXJ+BuA56usuyYk7Gd5GkEe024v6C3D8AXBJKxnElmmYjSmNaCin31J6oxeCpeyx8TQDFvJFXL78+ZUCtQyImkankypvmWd7X3IrF9uevoJnQZV0/EDFCi5Xt1+JHOSz/vvcFqrlKsBqdQGKZ7BOhbNLiYM5BnRCxpEW9Ft0QD6FPM2KwcumTsz/BX1FPN5XBXcHG3yE79x0dRLm3geMkY/m1qoYKPMxmV/v8M/7cAAwBKv7Bm64QycAAAAABJRU5ErkJggg==';


var getCategoryIcon = function (type) {
    switch (type) {
        case "1":
            return imgMobility;
        case "2":
            return imgCar;
        case "3":
            return imgLeisure;
        case "4":
            return imgFood;
        case "5":
            return imgLife;
        case "6":
            return imgPublic;
        case "7":
            return imgWellness;
        case "8":
            return imgShop;
        default:
            return imgCategoryEmpty;
    }
};

var getCategoryIconUrl = function (category) {
    switch (category) {
        case "0":
            return BASE_URL + "/img/empty.png";
        case "1":
            return BASE_URL + "/img/icon_mobility@3x.png";
        case "2":
            return BASE_URL + "/img/icon_car@3x.png";
        case "3":
            return BASE_URL + "/img/icon_leisure@3x.png";
        case "4":
            return BASE_URL + "/img/icon_food@3x.png";
        case "5":
            return BASE_URL + "/img/icon_life@3x.png";
        case "6":
            return BASE_URL + "/img/icon_public@3x.png";
        case "7":
            return BASE_URL + "/img/icon_wellness@3x.png";
        case "8":
            return BASE_URL + "/img/icon_shop@3x.png";
        default:
            return getCategoryIconUrl("0");
    }
};

var extractFeatures = function (spot) {
    var features = [];


    features.push({
        name: "is_flat",
        icon_url: BASE_URL + "/img/equipment1.png",
        available: spot.is_flat === "1"
    });
    
    features.push({
        name: "is_spacious",
        icon_url: BASE_URL + "/img/equipment2.png",
        available: spot.is_spacious === "1"
    });
    
    features.push({
        name: "is_silent",
        icon_url: BASE_URL + "/img/equipment3.png",
        available: spot.is_silent === "1"
    });
    
    features.push({
        name: "is_bright",
        icon_url: BASE_URL + "/img/equipment4.png",
        available: spot.is_bright === "1"
    });
    
    features.push({
        name: "count_parking",
        icon_url: BASE_URL + "/img/equipment9.png",
        available: spot.count_parking > 0
    });
    
    features.push({
        name: "count_wheelchair_parking",
        icon_url: BASE_URL + "/img/equipment7.png",
        available: spot.count_wheelchair_parking > 0
    });
    
    features.push({
        name: "count_elevator",
        icon_url: BASE_URL + "/img/equipment6.png",
        available: spot.count_elevator > 0
    });
    
    features.push({
        name: "count_wheelchair_rent",
        icon_url: BASE_URL + "/img/equipment10.png",
        available: spot.count_wheelchair_rent > 0
    });
    
    features.push({
        name: "count_wheelchair_wc",
        icon_url: BASE_URL + "/img/equipment5.png",
        available: spot.count_wheelchair_wc > 0
    });
    
    features.push({
        name: "count_ostomate_wc",
        icon_url: BASE_URL + "/img/equipment8.png",
        available: spot.count_ostomate_wc > 0
    });
    
    features.push({
        name: "count_nursing_room",
        icon_url: BASE_URL + "/img/equipment11.png",
        available: spot.count_nursing_room > 0
    });
    
    features.push({
        name: "count_babycar_rent",
        icon_url: BASE_URL + "/img/equipment12.png",
        available: spot.count_babycar_rent > 0
    });
    
    features.push({
        name: "with_assistance_dog",
        icon_url: BASE_URL + "/img/equipment13.png",
        available: spot.with_assistance_dog === "1"
    });
    
    features.push({
        name: "is_universal_manner",
        icon_url: BASE_URL + "/img/equipment14.png",
        available: spot.is_universal_manner === "1"
    });
    
    features.push({
        name: "with_credit_card",
        icon_url: BASE_URL + "/img/equipment15.png",
        available: spot.with_credit_card === "1"
    });
    
    features.push({
        name: "with_emoney",
        icon_url: BASE_URL + "/img/equipment16.png",
        available: spot.with_emoney === "1"
    });

    features.push({
        name: "count_plug",
        icon_url: BASE_URL + "/img/equipment17.png",
        available: spot.count_plug > 1
    });

    features.push({
        name: "count_wifi",
        icon_url: BASE_URL + "/img/equipment18.png",
        available: spot.count_wifi > 0
    });

    features.push({
        name: "count_smoking_room",
        icon_url: BASE_URL + "/img/equipment19.png",
        available: spot.count_smoking_room > 0
    });

    return features;
};

var getRatingIcon = function (point) {
    switch (point) {
        case 0:
            return imgRating0;
        case 1:
            return imgRating1;
        case 2:
            return imgRating2;
        case 3:
            return imgRating3;
        case 4:
            return imgRating4;
        case 5:
            return imgRating5;
        default:
            return imgRating0;
    }
};

var drawWrapText = function (ctx, text, x, y, maxWidth, lineHeight, maxLines) {
    ctx.save();
    if (text == '') {
        return 0;
    }
    
    var words = text.split(' ');
    var arr = words;
    var line = '';
    var lineCount = 0;
    var realWidth = 0;
    
    if (words.length == 1) {
        arr = text.split('');
    }
    
    for (var n = 0; n < arr.length; n++) {
        var line_tmp = line + ' ' + arr[n];
        var metrics_tmp = ctx.measureText(line_tmp);
        var testWidth_tmp = metrics_tmp.width;
        if (testWidth_tmp > maxWidth) {
            var m_tmp = ctx.measureText(line);
            realWidth = m_tmp.width > realWidth ? m_tmp.width : realWidth;
            drawText(ctx, line, x, y);
            line = '';
            y += lineHeight;
            lineCount++;
        } else {
            line = line_tmp;
        }
        if (lineCount >= maxLines) {
            return realWidth;
        }
    }
    if (line != '' && lineCount < maxLines) {
        var m_tmp = ctx.measureText(line);
        realWidth = m_tmp.width > realWidth ? m_tmp.width : realWidth;
        drawText(ctx, line, x, y);
    }
    return realWidth;
};

var drawText = function(ctx, text, x, y){
    ctx.save();
    //ctx.font = "10px sans-serif";
    ctx.strokeStyle = 'white';
    ctx.lineWidth = 2;
    ctx.strokeText(text, x, y);
    ctx.fillStyle = 'black';
    ctx.fillText(text, x, y);
    ctx.restore();
};

var drawRatingText = function (ctx, point, x, y) {
    ctx.save();
    ctx.strokeStyle = 'white';
    ctx.lineWidth = 2;
    ctx.strokeText(point, x, y);
    ctx.fillStyle = '#FF791F';
    ctx.fillText(point, x, y);
    ctx.restore();
    
    var metrics = ctx.measureText(point);
    return metrics.width;
};

function createMarkerCateIcon (marker, w = 28, h = 40) { // custom width, height when mouse hover
    var width = w;
    var height = h;
    var canvas = document.createElement("canvas");
    canvas.width = width;
    canvas.height = height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(getCategoryIcon(marker['tag'].place_category_type_id), 0, 0, w, h);
    return canvas.toDataURL();
}

/*
* AnhMH 2016-06-02
* Create big icon when mouse hover
*/
var createBigMarkerIcon = function (place, fs, pw, ph, iw, ih, forceCreate) {
    var pin_width = pw;
    var pin_height = ph;
    var realWidth = 0;
    var textleft = iw+4;
    var canvas = document.createElement("canvas");
    canvas.width = pin_width;
    canvas.height = pin_height;
    var ctx = canvas.getContext("2d");
    ctx.font = fs+"px sans-serif";
    ctx.drawImage(getCategoryIcon(place.place_category_type_id), 0, 0, iw, ih);
    var intRating = Math.floor( Number(place.review_point) );
    if (intRating > 0) {
        ctx.drawImage(getRatingIcon(intRating), textleft, ph-12);
        var realWidthTmp = drawRatingText(ctx, place.review_point, textleft + 42, ph-4);
        realWidth = realWidthTmp + textleft + 42 > realWidth ? realWidthTmp + textleft + 42 : realWidth;
    }

    if (!place.name) {
        if (forceCreate) {
            var realWidthTmp = drawWrapText(ctx, ' ', textleft, fs, pin_width - textleft, fs, 2);
            realWidth = realWidthTmp + textleft > realWidth ? realWidthTmp + textleft : realWidth;
        } else {
            return;
        }
    } else {
        var realWidthTmp = drawWrapText(ctx, place.name, textleft, fs, pin_width - textleft, fs, 2);
        realWidth = realWidthTmp + textleft > realWidth ? realWidthTmp + textleft : realWidth;
    }

    /*// Debug begin
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.lineWidth = 1;
    ctx.lineTo(pin_width - 1, 0);
    ctx.lineTo(pin_width - 1, pin_height);
    ctx.lineTo(0, pin_height);
    ctx.lineTo(0, 0);
    ctx.strokeStyle = '#990000';
    ctx.stroke();
    // Debug end */

    if (realWidth < pin_width) {
        pin_width = realWidth;
    }

    var newCanvas = document.createElement('canvas');
    var context = newCanvas.getContext('2d');
    newCanvas.width = pin_width;
    newCanvas.height = pin_height;
    context.drawImage(canvas, 0, 0);

    delete canvas;

    return newCanvas.toDataURL();
}

var createMarkerIcon = function (place, forceCreate) {
    var pin_width = 140;
    var pin_height = 40;
    var realWidth = 0;
    var textleft = 32;
    var canvas = document.createElement("canvas");
    canvas.width = pin_width;
    canvas.height = pin_height;
    var ctx = canvas.getContext("2d");
    ctx.font = "11px sans-serif"; // resize font

    // draw category icon
    ctx.drawImage(getCategoryIcon(place.place_category_type_id), 0, 0);

    // draw rating icon
    var intRating = Math.floor( Number(place.review_point) );
    if (intRating > 0) {
        ctx.drawImage(getRatingIcon(intRating), textleft, 32);
        var realWidthTmp = drawRatingText(ctx, place.review_point, 74, 38);
        realWidth = realWidthTmp + 74 > realWidth ? realWidthTmp + 74 : realWidth;
    }
    
    if (!place.name) {
        if (forceCreate) {
            var realWidthTmp = drawWrapText(ctx, ' ', textleft, 10, pin_width - textleft, 10, 2);
            realWidth = realWidthTmp + textleft > realWidth ? realWidthTmp + textleft : realWidth;
        } else {
            return;
        }
    } else {
        var realWidthTmp = drawWrapText(ctx, place.name, textleft, 10, pin_width - textleft, 10, 2);
        realWidth = realWidthTmp + textleft > realWidth ? realWidthTmp + textleft : realWidth;
    }

    // AnhMH 2016-06-01 Remove category name
    /*if (!place.place_category_name) {
        if (forceCreate) {
            var realWidthTmp = drawWrapText(ctx, ' ', textleft, 30, pin_width - textleft, 10, 1);
            realWidth = realWidthTmp + textleft > realWidth ? realWidthTmp + textleft : realWidth;
        } else {
            return;
        }
    } else {
        var realWidthTmp = drawWrapText(ctx, place.place_category_name, textleft, 30, pin_width - textleft, 10, 1);
        realWidth = realWidthTmp + textleft > realWidth ? realWidthTmp + textleft : realWidth;
    }*/
    
    if (realWidth < pin_width) {
        pin_width = realWidth;
    }
    
    /*// Debug begin
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.lineWidth = 1;
    ctx.lineTo(pin_width - 1, 0);
    ctx.lineTo(pin_width - 1, pin_height);
    ctx.lineTo(0, pin_height);
    ctx.lineTo(0, 0);
    ctx.strokeStyle = '#990000';
    ctx.stroke();
    // Debug end*/
    
    var newCanvas = document.createElement('canvas');
    var context = newCanvas.getContext('2d');
    newCanvas.width = pin_width;
    newCanvas.height = canvas.height;
    context.drawImage(canvas, 0, 0);
    
    delete canvas;
    
    return newCanvas;// newCanvas.toDataURL()
};

/**
 * Script for Map on Top page
 */

var MIN_CAMERA_ROOM = 13;

var LANGUAGE_TYPE_JA = 1;
var LANGUAGE_TYPE_EN = 2;
var LANGUAGE_TYPE_ES = 5;

var map;
var currentMarker;
var intervalBlinkCurrentLocation;
// variable content all makers on map
var markers = {};
var openningMarker, tmpMarker;
var xhrLoadNearSpot;
var curCategory = 0; // 0 = all categories

window.SpotFilter = window.SpotFilter || {};

SpotFilter.inSearchKeyword = false;
SpotFilter.inFilterFeatures = false;
SpotFilter.inFilterCategory = false;
SpotFilter.parameters = {};

SpotFilter.searchKeyword = function (keyword) {
    this.inSearchKeyword = true;
    this.inFilterFeatures = false;
    this.inFilterCategory = false;
    this.parameters['keyword'] = keyword;
    this.parameters['types'] = GooglePlaceType.getAll();
    delete this.parameters['place_category_type_id'];
};

SpotFilter.filterFeatures = function () {
    this.inSearchKeyword = false;
    this.inFilterFeatures = true;
    this.inFilterCategory = false;
    delete this.parameters['keyword'];
    delete this.parameters['place_category_type_id'];
    this.parameters['types'] = GooglePlaceType.getAll();
};

SpotFilter.filterCategory = function (category) {
    this.inSearchKeyword = false;
    this.inFilterFeatures = false;
    this.inFilterCategory = true;
    this.parameters['types'] = GooglePlaceType.getTypeList(category);
    this.parameters['place_category_type_id'] = category;
    delete this.parameters['keyword'];
};

SpotFilter.clear = function () {
    this.inSearchKeyword = false;
    this.inFilterFeatures = false;
    this.inFilterCategory = false;
    this.parameters['types'] = GooglePlaceType.getAll();
    delete this.parameters['keyword'];
    delete this.parameters['place_category_type_id'];
};

SpotFilter.getParameters = function () {
    
    var newObject = $.extend({}, this.parameters);
    if(this.inFilterFeatures) {
        delete newObject['keyword'];
        
        var point = getCookie('search_point');
        if (!!point && point > 0) {
            newObject['review_point'] = point;
        }

        var steps = getCookie('search_step');
        if (!!steps && steps >= 0) {
            newObject['entrance_steps'] = steps;
        }

        var facilities = getCookie('search_facility');
        if (facilities) {
            $.each(facilities.split(","), function (i, key) {
                newObject[key] = 1;
            });
        }
        
        var physicalTypes = getCookie('search_physicaltype');
        if (physicalTypes) {
            newObject['physical_type_id'] = physicalTypes;
        }
    }
    return newObject;
};

var shouldShowMarker = true;
var updateMarker = function (visible) {
    shouldShowMarker = visible;
    $.each(markers, function (i, marker) {
        marker.setVisible(shouldShowMarker);
    });
};

//leftMenuItemFacilityContributor
/**
 * When DOM ready
 */
$(document).ready(function () {

    // Create new spot
    $('#topMapNewSpot').on('click', function(){ newSpot(false); });
    $('#dlgPopupAddSpotCategory').on('change', setIconCategory);

    // Go current location
    $('#topMapCurrentLocation').on('click', goCurrentLocation);
    
    // Register named template from script
    $.templates({
        leftSpotItem: {
            markup: "#leftSpotItemTemplate",
            helpers: {
              getCategoryIconUrl: getCategoryIconUrl,
              features: extractFeatures
            }
        }
    });
    
    $("#dlgPopupAdvancedSearchTopBtn").click(function (event) {
        if ($('#dlgPopupAdvancedSearchTopBtn').hasClass('disableBtn')) {
            return false;
        }
        
        event.preventDefault();
        $("#dlgPopupAdvancedSearchTitleCancel").click();
        
        // Save current search condition to cookie
        setCookie('search_point', getCurrentPoint(), 1);
        setCookie('search_step', getCurrentStep(), 1);
        setCookie('search_facility', facilityCurrent, 1);
        setCookie('search_physicaltype', physicalTypeCurrent, 1);
        
        // Set spot header condition
        hideLeftSpotHeaderBtn();
        var value = getCurrentFacility();
        if (value != '') {
            value = value.split(",");
        } else {
            value = [];
        }
        
        // KienNH 2016/06/03 begin
        var value2 = getCurrentPhysicalType();
        if (value2 != '') {
            value2 = value2.split(",");
        } else {
            value2 = [];
        }
        for (var ipt = 0; ipt < value2.length; ipt++) {
            value.push('physical_type_' + value2[ipt]);
        }
        // KienNH end
        
        var found = 0;
        var max_icon = 8;// KienNH 2016/06/03
        $('#leftSpotSearchTypeAdvanced .dlgPopupAdvancedSearchTopEquipmentItem').each(function() {
            var id = $(this).data('id');
            if (id !== undefined) {     
                $(this).hide();
                if ($.inArray(id+'', value) !== -1) {
                    if (found < max_icon) {// KienNH 2016/06/03 change from 5 to 8
                        $(this).show();
                    }
                    found++;
                }
            }
        });
        if (found > 0) {
            // KienNH 2016/06/03 begin
            if (found > max_icon) {
                $('#leftSpotSearchTypeAdvanced .dlgPopupAdvancedSearchTopEquipmentItem[data-id="more"]').show();
            }
            // KienNH end
            
            $('#leftSpotSearchTypeAdvanced').css('display', 'inline-block');
        }
        
        openSideView(SIDEVIEW_TYPE.SPOT_SEARCH_ADVANCE, searchFeatures, true);
    });
    
    $(".dlgPopupCategoryItem").click(function (e) {
        e.preventDefault();
        $("#wrapPanelMain").click();
        var category = Number($(this).attr("data-category-id"));
        
        openSideView(SIDEVIEW_TYPE.SPOT_SEARCH_CATEGORY, function(){
            searchCategories(category);
        }, true);
    });

    $('#leftSpotClose').on('click', function () {
        SpotFilter.clear();
        loadNearSpot();
    });

    $(document).on("spotDetail:close", function (e) {
        unsetMarkerEffect();
    });
    
    // Zoom in
    $('#topMapZoomIn').on('click', function(){ setMapZoom(true); });
    
    // Zoom out
    $('#topMapZoomOut').on('click', function(){ setMapZoom(false); });

    $('#dlgPopupAddSpotBtnRegister').click(function (e) {
        
        if (!newSpotMarker || !newSpotMarker.getMap()) {
            return;
        }

        var name = $('#add_new_spot_name').val().trim();
        if (name.length === 0) {
            showErrorPopup(ERROR_MESSAGE_SPOT_NAME_EMPTY);
            return;
        }

        var category = $('#add_new_spot_category').val();
        if (category < 1 || category > 8 ) {
            showErrorPopup(ERROR_MESSAGE_SPOT_CATEGORY_EMPTY);
            return;
        }

        var address = $('#add_new_spot_address').val().trim();

        $.ajax({
            url: BASE_URL + "/top/add_spot.json",
            method: "POST",
            data: {
                name: name,
                location: newSpotMarker.getPosition().toUrlValue(),
                address: address,
                place_category_type_id: category
            }
        }).done(function(response) {
            newSpotMarker.setMap(null);
            loadNearSpot();
            closeAddNewSpotPopup();
            $('#add_new_spot_name').val("");
            $('#add_new_spot_category').val(0);
            $('#add_new_spot_address').val("");
        });
    });

    initMap();
});

/**
 * Init and show default map
 */
function initMap() {
    var style = [
        {
            "elementType": "labels",
            "stylers": [
                {"visibility": "off"}
            ]
        }
    ];

    var styleName = 'Bmaps';
    
    // KienNH 2016/06/03 begin
    var remLatitude = getCookie(cookieLatitude);
    var remLongitude = getCookie(cookieLongitude);
    if (!remLatitude || !remLongitude) {
        remLatitude = defaultLatitude;
        remLongitude = defaultLongitude;
        
        setCookie(cookieLatitude, defaultLatitude, 1);
        setCookie(cookieLongitude, defaultLongitude, 1);
    }
    // KienNH end

    var option = {
        zoom: 16,
        disableDefaultUI: true,
        center: new google.maps.LatLng(remLatitude, remLongitude),// KienNH 2016/06/03 change to use variable remLatitude, remLongitude
        mapTypeId: styleName,
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP]
        }
    };

    var container = document.getElementById('topMapContainer');
    if (typeof container === 'undefined' || !container || container.length <= 0) {
        return false;
    }
    map = new google.maps.Map(container, option);
    var styledMapType = new google.maps.StyledMapType(style, {name: styleName});
    map.mapTypes.set(styleName, styledMapType);
    map.addListener('idle', loadNearSpot);
    map.addListener('click', function(){
        $('#headerSuggestionResult').removeClass('is-open');// Close search suggestion
    });
}

function loadNearSpot(loadForSideView, textSearch) {
    if (map && map.getZoom() < MIN_CAMERA_ROOM) {
        $.each(markers, function (i, place) {
            place.setMap(null);
        });
        markers = {};
        return;
    }
    
    // KienNH 2016/06/03 begin
    if (map) {
        setCookie(cookieLatitude, map.getCenter().lat(), 1);
        setCookie(cookieLongitude, map.getCenter().lng(), 1);
    }
    // KienNH end

    var textSearch = !map || typeof textSearch !== 'undefined' && textSearch ? true : false;
    var p = SpotFilter.getParameters();
    p["location"] = map ? map.getCenter().toUrlValue() : '0,0';
    p["radius"] = map ? getDistance(map.getBounds().getNorthEast(), map.getBounds().getSouthWest()) / 2 : 0;
    var itemKey = window.location.hash.substr(1); 
    var arrayItemKey = itemKey.split("|");
    if (arrayItemKey.length == 2) {
        if (arrayItemKey[0]) {
            p["google_place_id"] = arrayItemKey[0];
        }
        if (arrayItemKey[1]) {
            p["place_id"] = arrayItemKey[1];
        }
    }
    
    if (typeof loadForSideView !== 'undefined' && loadForSideView) {
        $("#leftSideViewLoader").show();
        $('#spotBody').empty();
    }
    
    if (textSearch) {
        p["text_search"] = 1;
    }

    // cancel previous request
    !!xhrLoadNearSpot && xhrLoadNearSpot.state() === "pending" && xhrLoadNearSpot.abort();
    xhrLoadNearSpot = $.ajax({
        url: BASE_URL + "/top/near_by_search.json",
        method: "POST",
        data: p
    }).done(function (places) {
        // clone markers
        var needToRemoveMarkers = $.extend({}, markers);
        markers = {};

        $.each(places, function (i, place) {
            place.google_place_id = place.google_place_id ? place.google_place_id : '0';
            place.place_id = place.place_id ? place.place_id : '0';
            var key = place.google_place_id + "-" + place.place_id;
            if (needToRemoveMarkers[key] !== undefined) {
                markers[key] = needToRemoveMarkers[key];
                markers[key].setVisible(shouldShowMarker);
                delete needToRemoveMarkers[key];
            } else {
                if (openningMarker &&
                        openningMarker.tag.google_place_id == place.google_place_id &&
                        openningMarker.tag.place_id == place.place_id) {
                    // Don't create new Pin
                } else if (openningMarker &&
                        openningMarker.tag.google_place_id == place.google_place_id &&
                        openningMarker.tag.place_id == 0 &&
                        place.place_id != 0) {
                    // Case: API added place to DB when load data from Google
                    openningMarker.tag.place_id = place.place_id;
                } else {
                    createMarkerPlace(place);
                }
            }
        });

        $.each(needToRemoveMarkers, function (key, place) {
            if (place !== openningMarker) {
                place.setMap(null);
            }
        });
        
        /*$.each(places, function (i, place) {
            var key = place.google_place_id + "-" + place.place_id;
            if (markers[key] === undefined) {
                createMarkerPlace(place);
            }
        });*/

        if (typeof loadForSideView !== 'undefined' && loadForSideView) {
            $("#leftSideViewLoader").hide();
            $("#spotBody").html($.render.leftSpotItem(places));
        }
        if (p["google_place_id"] !== undefined || p["place_id"] !== undefined) { 
            // remove hash
            history.pushState("", document.title, window.location.pathname + window.location.search);
            goLeftSpotDetail(undefined, p["google_place_id"], p["place_id"], 1);
        }
        if (placeTypeFilter != null) {
            hideMarkerByTypeId(placeTypeFilter);
        }
        markerCollisionDetection(markers);
    });
};

// get markers
function getMarkers() {
    return markers;
}

/**
 * Request and go current location
 */
function goCurrentLocation() {
    // Browser support
    if (!!navigator.geolocation) {
        // Add effect
        blinkCurrentLocation();

        navigator.geolocation.getCurrentPosition(function (position) {
            // Set new position
            var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            map.setZoom(16);
            map.panTo(geolocate);

            // ThaiLH: Write cookie user's position
            setCookie(cookieLatitude, position.coords.latitude, 1);
            setCookie(cookieLongitude, position.coords.longitude, 1);
            
            // Remove old marker
            try {
                currentMarker.setMap(null);
            } catch (e) {
            }

            // Create marker
            currentMarker = new google.maps.Marker({
                position: geolocate,
                map: map,
                draggable: false,
                optimized: false,
                animation: google.maps.Animation.DROP,
                icon: {
                    url: BASE_URL + '/img/currentPosition.png',
                    anchor: new google.maps.Point(12, 12),
                    scaledSize: new google.maps.Size(24, 24)
                }
            });

            // Remove effect
            blinkCurrentLocation(true);
        }, function (error) {
            // On error: remove effect
            blinkCurrentLocation(true);
            
            // Show error
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    showErrorPopup(MESSAGE_GEO_ERROR_PERMISSION_DENIED);
                    break;
                case error.POSITION_UNAVAILABLE:
                    showErrorPopup(MESSAGE_GEO_ERROR_POSITION_UNAVAILABLE);
                    break;
                case error.TIMEOUT:
                    showErrorPopup(MESSAGE_GEO_ERROR_TIMEOUT);
                    break;
                case error.UNKNOWN_ERROR:
                default:
                    showErrorPopup(MESSAGE_GEO_ERROR_UNKNOWN_ERROR);
                    break;
            }
        },
        {
            maximumAge: 60000,
            timeout: 10000,
            enableHighAccuracy: true
        });
    } else {
        showErrorPopup(MESSAGE_GEO_ERROR_BROWSER_NOT_SUPPORT);
    }
}

/**
 * On-Off blink effect
 * 
 * @param {bollean} off
 */
function blinkCurrentLocation(off) {
    var btn = $('#topMapCurrentLocation');

    if (typeof off !== 'undefined' && off) {
        // Off
        btn.removeClass('blink');
        try {
            clearInterval(intervalBlinkCurrentLocation);
        } catch (e) {
        }
    } else {
        // On
        btn.addClass('blink');
        intervalBlinkCurrentLocation = setInterval(function () {
            btn.toggleClass('blink');
        }, 100);
    }
}

/************************************************
 * Search
 ************************************************/

function headerSearch() {
    var menu = $('#leftMenu');
    
    if(menu.is(':visible')) {
        showHideLeftMenu(null, null);
    }
    openSideView(SIDEVIEW_TYPE.SPOT_SEARCH_KEYWORD, searchKeyword, true);
    
    return false;
}

/**
 * Get spot data when search from header
 */
function searchKeyword() {
    hideLeftSpotHeaderBtn();
    $('#headerSuggestionResult').removeClass('is-open');// Close search suggestion
    $('#leftSpotHeader span').html(SEARCH_KEYWORD_TITLE);
    
    SpotFilter.searchKeyword($("#headerKeyword").val());
    loadNearSpot(true, true);
}

function searchFeatures() {
    $('#leftSpotHeader span').html(SEARCH_ADVANCED_TITLE);
    
    SpotFilter.filterFeatures();
    loadNearSpot(true);
}

function searchCategories(category) {
    hideLeftSpotHeaderBtn();
    $('#leftSpotHeader span').html(SEARCH_CATEGORY_TITLE);
    $('#leftSpotSearchTypeCategory').css('display', 'inline-block').text(GooglePlaceType.getCategoryName(category));
    
    SpotFilter.filterCategory(category);
    loadNearSpot(true);
}

function openSpotDetail() {
    $('#leftSpotContainer').show();
    $('#leftRankingContainer').hide();

    $(document).trigger("spotDetail:close");

    // Show panel
    if (!$("#leftSpotDetailAndEdit").is(":visible")) {
        $('#leftSpotMainContainerSlider').animate({'left': '0px'}, speedSpot);
    }
}

/**
 * Create new spot
 * @param {boolean} showForm false: show message, true: show form
 * @returns {undefined}
 */
function newSpot(showForm) {
    // KienNH, 2015/11/26: Show login popup
    if (GUEST != 0) {
        return showGuestPopup();
    }
    
    var addSpotPopup = $('#dlgPopupAddSpot');
    var title = $('#dlgPopupAddSpotTitle');
    var btn = $('#topMapNewSpot');
    var popupHeight = 328;
    var transparentHeight = 100;
    var headerHeight = $('header').outerHeight();
    var titleHeight = title.outerHeight();
    
    // Set layout for button
    btn.addClass('on');
    
    // Ignore action when form is displaying
    if(addSpotPopup.hasClass("show-form")) {
        return;
    }
    updateMarker(false);

    if (!showForm) {
        addSpotPopup.css('top', '117px').css('margin-top', '0px');
        
        // Only show title
        addSpotPopup.height(titleHeight);
        
        // Set cursor style
        map.setOptions({draggableCursor: 'crosshair'});
        listenerClickAddSpot  = map.addListener('click', function(e){
            // Try clear old marker
            try {
                newSpotMarker.setMap(null);
            } catch (err) {}
            
            // Create new marker
            var latLng = e.latLng;
            newSpotMarker = new google.maps.Marker({
                position: latLng,
                map: map,
                draggable: true,
                optimized: false,
                icon: {
                    url: BASE_URL + '/img/pin2.png',
                    anchor: new google.maps.Point(16, 41),
                    scaledSize: new google.maps.Size(33, 41)
                }
            });
            
            // Event when move pin
            try {
                google.maps.event.removeListener(listenerMoveNewSpotMarker);
            } catch (e) {}
            listenerMoveNewSpotMarker = google.maps.event.addListener(newSpotMarker, 'dragend', function (ev) {
                var latLng = ev.latLng;
                panMapForNewSpot(latLng);
            });
            
            // Ignore action when form is displaying
            if (addSpotPopup.hasClass("show-form")) {
                panMapForNewSpot(latLng);
                return;
            }
            
            // Open form
            newSpot(true);
            
            // Move map
            panMapForNewSpot(latLng);
        });
    } else {
        // Show form
        addSpotPopup.height(popupHeight);
        addSpotPopup.addClass("show-form");
        addSpotPopup.css('top', '50%').css('margin-top', '-' + (popupHeight / 2 - transparentHeight / 2 - headerHeight / 2) + 'px');
        
        scalePopup(addSpotPopup, transparentHeight);
    }
    
    addSpotPopup.fadeIn('fast');
    
    // Close
    $('#dlgPopupAddSpotBtnCancel, #dlgPopupAddSpotCloseTop').unbind('click').bind('click', closeAddNewSpotPopup);
    
    return;
}

var closeAddNewSpotPopup = function () {
    // Try clear old marker
    try {
        newSpotMarker.setMap(null);
    } catch (e) {}

    // Try clear event
    try {
        google.maps.event.removeListener(listenerClickAddSpot);
    } catch (e) {}
    
    try {
        google.maps.event.removeListener(listenerMoveNewSpotMarker);
    } catch (e) {}

    // Hide popup
    var addSpotPopup = $('#dlgPopupAddSpot');
    addSpotPopup.fadeOut('fast', function () {
        addSpotPopup.removeClass("show-form");
        updateMarker(true);
    });
    $('#topMapNewSpot').removeClass('on');
    
    // Reset cursor style
    map.setOptions({draggableCursor: null});
};

/**
 * Set category icon to selectbox
 */
function setIconCategory() {
    //var select = $('#dlgPopupAddSpotCategory');
    //var option = $('option:selected', select);
}

/**
 * Zoom map in/out
 * @param {boolean} zoomIn
 */
function setMapZoom(zoomIn) {
    var currentZoom = map.getZoom();
    if (typeof zoomIn !== 'undefined' && zoomIn) {
        map.setZoom(currentZoom + 1);
    } else {
        map.setZoom(currentZoom - 1);
    }
}

/**
 * Show Marker at center of map, effect it
 * @param {object} name
 */
function markerEffectWhenClickOnSpot(key) {
    unsetMarkerEffect();// Unset old
    
    try {
        if (markers[key]) {
            markers[key].setZIndex(1000);
            markers[key].setAnimation(google.maps.Animation.BOUNCE);
            map.panTo(markers[key].getPosition());
            openningMarker = markers[key];
        }
    } catch (e) {
        
    }
}

/*
 * Unset marker effect when close left spot detail
 */
function unsetMarkerEffect(delFlg) {
    try {
        if (!!openningMarker) {
            var key = openningMarker.tag.google_place_id + "-" + openningMarker.tag.place_id;
            
            if (!markers[key]) {
                markers[key] = openningMarker;
            }
            
            markers[key].setAnimation(null);
            markers[key].setZIndex(0);
            openningMarker = null;
            
            if (delFlg) {
                markers[key].setMap(null);
                delete markers[key];
            }
        }
    } catch(e) {
        
    }
}

/**
 * Move map to center window
 * @param {Object} latLng
 */
function panMapForNewSpot(latLng) {
    var addSpotPopup = $('#dlgPopupAddSpot');
    
    try {
        var transparentHeight = 100;
        var headerHeight = $('header').outerHeight();
        var mapContainerHeight = $('#topMapContainer').outerHeight();// Without header header
        var offsetPopup = addSpotPopup.offset();// With header height
        var y1 = mapContainerHeight / 2;
        var y2 = (offsetPopup.top - headerHeight) - (transparentHeight / 2);
        var offsety = y1 - y2;
        var point1 = map.getProjection().fromLatLngToPoint(latLng);
        var point2 = new google.maps.Point(0, (offsety / Math.pow(2, map.getZoom())) || 0);
        map.panTo(map.getProjection().fromPointToLatLng(new google.maps.Point(
            point1.x - point2.x,
            point1.y + point2.y
        )));
    } catch(err) {}
    
    try {
        // Set position for form
        addSpotPopup.find('#dlgPopupAddSpotLat').val(latLng.lat());
        addSpotPopup.find('#dlgPopupAddSpotLng').val(latLng.lng());
    } catch(err2) {}
}

/**
 * http://stackoverflow.com/questions/2674392/how-to-access-google-maps-api-v3-markers-div-and-its-pixel-position
 * @param {object} marker
 * @returns {google.maps.Point}
 */
function getMarkerPixel(marker) {
    var scale = Math.pow(2, map.getZoom());
    var nw = new google.maps.LatLng(
        map.getBounds().getNorthEast().lat(),
        map.getBounds().getSouthWest().lng()
    );
    var worldCoordinateNW = map.getProjection().fromLatLngToPoint(nw);
    var worldCoordinate = map.getProjection().fromLatLngToPoint(marker.getPosition());
    var pixelOffset = new google.maps.Point(
        Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale),
        Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale)
    );
    return pixelOffset;
}

/*
* AnhMH 2016-06-03
* Add effect when mouse hover marker
*/
var fadeBigMarker = function(marker, height, maxHeight, width, anchorWidth, delay, forceCreate) {
    if (height <= maxHeight) {
        var newicon = marker['tag']['marker_icon_url'];
        marker.setIcon({
            url: newicon,
            scaledSize: new google.maps.Size(width, height),
            anchor: new google.maps.Point(anchorWidth, height)
        });

        // increment height, width
        height += 6;

        // call this method again
        timeout = setTimeout(function() {
            fadeBigMarker(marker, height, maxHeight, width, anchorWidth, delay);
        }, delay);

    } else {
        height = 40;
    }
}

/*
* AnhMH 2016-06-03
* Add effect when marker display
*/
var fadeInMarker = function(marker, markerOpacity, delay) {

    if (markerOpacity <= 1) {

        marker.setOpacity(markerOpacity);

        // increment opacity
        markerOpacity += 0.05;

        // call this method again
        timeout = setTimeout(function() {
            fadeInMarker(marker, markerOpacity);
        }, delay);

    } else {
        markerOpacity = 0.05;
    }
}

/**
 * Create marker for 1 place
 * @param {object} place
 */
function createMarkerPlace(place, forceCreate) {
    place.google_place_id = place.google_place_id ? place.google_place_id : '0';
    place.place_id = place.place_id ? place.place_id : '0';
    var key = place.google_place_id + "-" + place.place_id;
    if (markers[key] !== undefined) {
        return markers[key];
    }

    var icon = createMarkerIcon(place, forceCreate);
    if (!!icon) {
        var location = {lat: Number(place.latitude), lng: Number(place.longitude)};
        markers[key] = new google.maps.Marker({
            position: location,
            map: map,
            title: place.name,
            clickable: true,
            visible: shouldShowMarker,
            icon: {
                url: icon.toDataURL(),
                anchor: new google.maps.Point( 14 , 40 )
            }
        });

        var pos = getMarkerPixel(markers[key]);
        place['marker_icon'] = icon;
        place['marker_width'] = icon.width;
        place['marker_height'] = icon.height;
        place['marker_pos_x'] = pos.x;
        place['marker_pos_y'] = pos.y;
        place['marker_icon_url'] = icon.toDataURL();
        markers[key]['tag'] = place;

        markers[key].addListener("click", function (e) {
            if (this === openningMarker) {
                return;
            }

            clearStack();
            markerOnClick = key;
            var placeClicked = markers[key]['tag'];
            openSpotDetail();
            goLeftSpotDetail(null, placeClicked.google_place_id, placeClicked.place_id, true);
            placeTypeFilter = place.place_category_type_id;
            hideMarkerByTypeId(placeTypeFilter);
        });

        /*
         * AnhMH 2016-06-02
         * Zoom in icon when mouse hover
         */
        markers[key].addListener("mouseover", function (e) {
            if (this === openningMarker) {
                return;
            }
            var width = this['tag']['marker_width'];
            var height = this['tag']['marker_height'];
            if (width == 3) {
                this.setIcon({
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 7,
                    fillColor: "#ff791f",
                    fillOpacity: 1,
                    strokeColor: "#ff791f",
                    strokeWeight: 1
                });
            } else {
                var newHeight = height + 20;
                var newWidth = width * newHeight / height;
                var anchorWidth = 28 / width * (newWidth) / 2;
                fadeBigMarker(this, height, newHeight, newWidth, anchorWidth, 60);
            }
        });

        /*
         * AnhMH 2016-06-02
         * Reset icon when mouseout
         */
        markers[key].addListener("mouseout", function (e) {
            clearTimeout(timeout);
            if (this['tag']['marker_width'] == 3) {
                this.setIcon({
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 3,
                    fillColor: "#ff791f",
                    fillOpacity: 1,
                    strokeColor: "#ff791f",
                    strokeWeight: 1
                });
            } else if (this['tag']['marker_width'] == 28) {
                var newicon = createMarkerCateIcon(this);
                this.setIcon({
                    url: newicon,
                    anchor: new google.maps.Point(14, 40)
                });
            } else {
                resetMarker(this);
            }
        });

        // AnhMH 2016-06-03
        fadeInMarker(markers[key], 0.03, 200);
        
        return markers[key];
    }
    
    return false;
}

function markerCollisionDetection (markers) {
    var checkKeyArr = [];
    $.each(markers, function (i, markeri) {
        var checkKeyi = checkKeyArr.indexOf(i);
        var z = '';
        var check = true;
        if (checkKeyi < 0 && markeri.getVisible()) {
            resetMarker(markeri);
            if (i == markerOnClick) {
                resetMarker(markeri);
                var z = markerOnClick;
                markerOnClick = '';
            } else {
                var ipos = getMarkerPixel(markeri);
                var cx = ipos.x - 14;
                var cy = ipos.y - 40;
                $.each(markers, function (j, markerj) {
                    var checkKeyj = checkKeyArr.indexOf(j);
                    if (markerj.getVisible() && j != i && checkKeyj < 0 && j != z ) {
                        var cWidth = markeri['tag']['marker_width'];
                        var cHeight = markeri['tag']['marker_height'];
                        var rect1 = {x: cx, y: cy, width: cWidth, height: cHeight};

                        var jpos = getMarkerPixel(markerj);
                        var mx = jpos.x - 14;
                        var my = jpos.y - 40;
                        var mWidth = markerj['tag']['marker_width'];
                        var mHeight = markerj['tag']['marker_height'];
                        var checkDetection = false;
                        if (mWidth == 3) {
                            var rect2 = {x: mx + 14, y: my + 40, width: mWidth, height: mHeight};
                            if (collisionDetection(rect1, rect2)) {
                                markerj.setVisible(false);
                                checkKeyArr.push(j);
                            }
                        } else {
                            var rect2 = {x: mx, y: my, width: mWidth, height: mHeight};
                            checkDetection = collisionDetection(rect1, rect2);
                        }

                        if (checkDetection) { // marker collision
                            var rect3 = {x: cx, y: cy, width: 28, height: 40};
                            var rect4 = {x: mx, y: my, width: 28, height: 40};
                            if (collisionDetection(rect3, rect4) == true) { // icon collision
                                if (my < cy) {
                                    markerj.setVisible(false);
                                    checkKeyArr.push(j);
                                } else {
                                    markerj['tag']['marker_width'] = 3;
                                    markerj['tag']['marker_height'] = 3;
                                    markerj.setIcon({
                                        path: google.maps.SymbolPath.CIRCLE,
                                        scale: 3,
                                        fillColor: "#ff791f",
                                        fillOpacity: 1,
                                        strokeColor: "#ff791f",
                                        strokeWeight: 1
                                    });
                                }
                            } else { // text collision
                                if (cx < mx) {
                                    var newicon = createMarkerCateIcon(markeri);
                                    markeri.setIcon({
                                        url: newicon,
                                        anchor: new google.maps.Point(14, 40)
                                    });
                                    markeri['tag']['marker_width'] = 28;
                                    markeri['tag']['marker_height'] = 40;
                                    markeri['tag']['marker_icon_url'] = newicon;
                                } else {
                                    var newicon = createMarkerCateIcon(markerj);
                                    markerj.setIcon({
                                        url: newicon,
                                        anchor: new google.maps.Point(14, 40)
                                    });
                                    markerj['tag']['marker_width'] = 28;
                                    markerj['tag']['marker_height'] = 40;
                                    markerj['tag']['marker_icon_url'] = newicon;
                                }
                            }
                        }
                    }
                });
            }
        }

    });
}

// Reset marker icon
function resetMarker(marker) {
    var icon = marker['tag']['marker_icon'];
    marker.setIcon({
        url: icon.toDataURL(),
        anchor: new google.maps.Point(14, 40)
    });
    marker['tag']['marker_width'] = icon.width;
    marker['tag']['marker_height'] = icon.height;
    marker['tag']['marker_icon_url'] = icon.toDataURL();
}

// collision detection
function collisionDetection (rect1, rect2) {
    if (rect1.x < rect2.x + rect2.width &&
    rect1.x + rect1.width > rect2.x &&
    rect1.y < rect2.y + rect2.height &&
    rect1.height + rect1.y > rect2.y ) {
        return true;
    }
    return false;
}

// Reset hide markers
function clearPlaceTypeFilter() {
    updateMarker(true);
    placeTypeFilter = null;
}

// Set type filter
function setPlaceTypeFilter(typeId) {
    placeTypeFilter = typeId;
    hideMarkerByTypeId(placeTypeFilter);
}

// Hide markers
function hideMarkerByTypeId (typeId) {
    $.each(markers, function (i, marker) {
        if (marker['tag'].place_category_type_id != typeId) {
            marker.setVisible(false);
        }
    });
}

/**
 * Create empty marker
 * @param {int} latitude
 * @param {int} longitude
 * @returns {google.maps.Marker}
 */
function createTmpMarker(latitude, longitude) {
    var placeTmp = {
        place_category_type_id: 0,
        place_category_name: '',
        name: '',
        latitude: latitude,
        longitude: longitude
    };
    
    var iconTmp = createMarkerIcon(placeTmp, true);
    var location = {lat: Number(placeTmp.latitude), lng: Number(placeTmp.longitude)};
    
    return new google.maps.Marker({
        map: map,
        position: location,
        icon: {
            url: iconTmp.toDataURL(),
            anchor: new google.maps.Point( 14 , 40 )
        }
    });
}
