function PreviewImage() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("imagen").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("uploadPreview").style.width = "150px";
        document.getElementById("uploadPreview").style.height = "150px";
        document.getElementById("uploadPreview").style.margin = "0px auto";
        document.getElementById("uploadPreview").src = oFREvent.target.result;
    };
}
$(document).bind("keypress", "body", function (e) {
    if (e.keyCode == 13) {
        return false;
    }
});
