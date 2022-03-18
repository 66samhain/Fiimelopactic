var player;

$(document).ready(function () {
    $('.play').click(function () {
        var youtubeId = $(this).data('video-id');
        var start = $(this).data('start');
        var end = $(this).data('end');
        if (!player) {
            player = new YT.Player('player', {
                height: '390',
                width: '640',
                videoId: youtubeId,
                playerVars: {
                    autoplay: 1,
                    loop: 1,
                    start: start,
                    end: end
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        } else {
            player.loadVideoById(
                {
                    'videoId': youtubeId,
                    'startSeconds': start,
                    'endSeconds': end
                }
            );
        }
    })
});

function onPlayerReady(event) {
    event.target.playVideo();
}

function onPlayerStateChange(event) {
    console.log('player-state-change');
}