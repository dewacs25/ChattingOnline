function zoomOnFocus() {
    // document.body.style.zoom = "150%";
}

function resetZoom() {
    document.body.style.zoom = "100%";
}

function pesan() {
    alert("hallo");
}

document.addEventListener("DOMContentLoaded", function () {
    var messages = document.querySelectorAll(".cardPesan");

    messages.forEach(function (message) {
        var content = message.querySelector(".message-content");
        var readMore = message.querySelector(".read-more");

        var contentText = content.textContent;

        if (contentText.length > 350) {
            content.classList.add("collapsed");
            readMore.style.display = "inline";

            readMore.addEventListener("click", function (e) {
                e.preventDefault();
                content.classList.remove("collapsed");
                readMore.style.display = "none";
            });
        } else {
            readMore.style.display = "none";
        }
    });
});

window.addEventListener('load', function() {
    document.getElementById('loading-overlay').style.display = 'none';
});

