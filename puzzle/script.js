$(document).ready(function () {
    const circles = $('.circle');
    const iconClasses = [
        ['fas fa-star', 'fas fa-moon', 'fas fa-sun'],
        ['fas fa-cloud', 'fas fa-bolt', 'fas fa-snowflake', 'fas fa-rain'],
        ['fas fa-tree', 'fas fa-leaf', 'fas fa-seedling', 'fas fa-flower'],
        ['fas fa-cat', 'fas fa-dog', 'fas fa-fish', 'fas fa-paw', 'fas fa-feather'],
        ['fas fa-car', 'fas fa-bicycle', 'fas fa-plane', 'fas fa-ship', 'fas fa-train', 'fas fa-rocket']
    ];

    let selectedCircle = null;

    function setBackgroundImages() {
        circles.each(function (index) {
            const size = 500 - index * 100;
            const offset = index * 50;
            $(this).css({
                'background-image': `url('https://png.pngtree.com/thumb_back/fw800/background/20231010/pngtree-high-resolution-background-showcasing-natural-patterns-of-sedimentary-rock-texture-image_13589630.png')`,
                'background-size': '500px 500px',
                'background-position': `-${offset}px -${offset}px`
            });
        });
    }

    function addIcons() { 
        circles.each(function (index) {
            const size = $(this).width();
            const iconCount = 13 - index * 2; // Takes value of 13, 11, 9, 7, 5
            const circleIcons = iconClasses[index];

            for (let i = 0; i < iconCount; i++) {
                const angle = (i / iconCount) * 2 * Math.PI;
                const x = Math.cos(angle) * size / 2 + size / 2;
                const y = Math.sin(angle) * size / 2 + size / 2;
                const randomIconClass = circleIcons[Math.floor(Math.random() * circleIcons.length)];
                const icon = $('<i>').addClass(`icon ${randomIconClass}`).css({
                    left: x - 10,
                    top: y - 10,
                    color: '#000'
                });
                $(this).append(icon);
            }
        });
    }

    function rotateCircle(circle, direction) {
        let rotation = parseInt($(circle).attr('data-rotation'));
        rotation += direction * 45;
        $(circle).attr('data-rotation', rotation);
        $(circle).css('transform', `rotate(${rotation}deg)`);

        // Update background position
        let bgPosition = $(circle).css('background-position').split(' ');
        let bgX = parseInt(bgPosition[0]);
        let bgY = parseInt(bgPosition[1]);
        bgX -= direction * 45;
        bgY -= direction * 45;
        $(circle).css('background-position', `${bgX}px ${bgY}px`);
    }

    circles.click(function () {
        circles.removeClass('selected');
        $(this).addClass('selected');
        selectedCircle = this;
    });

    $('#up-btn').click(function () {
        if (selectedCircle) {
            rotateCircle(selectedCircle, -1);
            checkSolution();
        }
    });

    $('#down-btn').click(function () {
        if (selectedCircle) {
            rotateCircle(selectedCircle, 1);
            checkSolution();
        }
    });

    function checkSolution() {
        let solved = true;
        circles.each(function () {
            if (parseInt($(this).attr('data-rotation')) % 360 !== 0) {
                solved = false;
                return false;
            }
        });
        if (solved) {
            alert('Puzzle solved! Redirecting to the next page...');
            // Uncomment the line below to redirect to another page
            // window.location.href = 'next-page.html';
        }
    }

    setBackgroundImages();
    addIcons();
});