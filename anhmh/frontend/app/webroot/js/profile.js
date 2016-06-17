/* 
 * KienNH
 * 
 * Script for user/profile page
 */

var defaultAvatarImageUrl = BASE_URL + '/img/avatar.png';
var defaultEmptyImageUrl = BASE_URL + '/img/empty.png';

$(document).ready(function () {
    // Set icon
    $('#prfIconFile').change(function () {
        var image = $('#prfIconPreview');
        setBackgroundImage(this, image, defaultAvatarImageUrl);
        $('#delete_avatar_flg').val('');
    });
    
    // Set cover
    $('#prfCoverFile').change(function () {
        var image = $('#prfCover');
        setBackgroundImage(this, image, defaultEmptyImageUrl);
        $('#delete_cover_flg').val('');
    });
    
    // Delete image
    $('#prfDeleteAvatar').on('click', function(){
        $('#delete_avatar_flg').val('1');
        $('#prfIconPreview').css('background-image', 'url(' + defaultAvatarImageUrl + ')');
    });
    $('#prfDeleteCover').on('click', function(){
        $('#delete_cover_flg').val('1');
        $('#prfCover').css('background-image', 'url(' + defaultEmptyImageUrl + ')');
    });
});

/**
 * Set background image
 * 
 * @param {object} input
 * @param {object} image : object to set background image
 * @param {string} defaultImageUrl : default image url
 */
function setBackgroundImage(input, image, defaultImageUrl) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            image.css('background-image', 'url(' + e.target.result + ')');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        image.css('background-image', 'url(' + defaultImageUrl + ')');
    }
}
