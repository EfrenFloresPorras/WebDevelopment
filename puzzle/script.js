function seededRandom(seed) {
    const x = Math.sin(seed) * 10000;
    return x - Math.floor(x);
}

let seed = 1;

$(document).ready(function () {
    const circles = $('.circle');
    const iconClasses = [
        ['fas fa-star', 'fas fa-moon', 'fas fa-sun', 'fas fa-meteor', 'fas fa-globe', 'fas fa-satellite'],
        ['fas fa-cloud', 'fas fa-bolt', 'fas fa-snowflake', 'fas fa-house'],
        ['fas fa-tree', 'fas fa-leaf', 'fas fa-seedling', 'fas fa-phone'],
        ['fas fa-cat', 'fas fa-dog', 'fas fa-fish', 'fas fa-paw', 'fas fa-feather'],
        ['fas fa-car', 'fas fa-heart', 'fas fa-plane', 'fas fa-ship', 'fas fa-train', 'fas fa-rocket']
    ];

    let selectedCircle = null;
    
    const solutionArray = ['fas fa-star', 'fas fa-cloud', 'fas fa-tree', 'fas fa-cat', 'fas fa-car']; // The solution goes from the outermost circle to the innermost circle
    let currentAttempt = new Array(5).fill(null);

    function setBackgroundImages() {
        circles.each(function (index) {
            const size = 500 - index * 100;
            const offset = index * 50;
            $(this).css({
                'background-image': `url("https://png.pngtree.com/thumb_back/fw800/background/20231010/pngtree-high-resolution-background-showcasing-natural-patterns-of-sedimentary-rock-texture-image_13589630.png")`,
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
            
            // Increase the number of icons for the largest circle
            const adjustedIconCount = index === 0 ? Math.max(iconCount, circleIcons.length * 2) : iconCount;
            
            // Create an array to keep track of icon usage
            let iconUsage = new Array(circleIcons.length).fill(0);
            
            // Calculate the step size for even distribution around the full circle
            const stepSize = 360 / adjustedIconCount;
    
            for (let i = 0; i < adjustedIconCount; i++) {
                // Calculate position around the full circle
                const angle = i * stepSize * (Math.PI / 180);
                const x = Math.cos(angle) * size / 2 + size / 2;
                const y = Math.sin(angle) * size / 2 + size / 2;
    
                // Select an icon that hasn't been used twice
                let randomIconIndex;
                let attempts = 0;
                do {
                    randomIconIndex = Math.floor(seededRandom(seed++) * circleIcons.length);
                    attempts++;
                    if (attempts > 100) {
                        // Fallback to prevent infinite loop
                        randomIconIndex = iconUsage.indexOf(Math.min(...iconUsage));
                        break;
                    }
                } while (iconUsage[randomIconIndex] >= 2);
    
                iconUsage[randomIconIndex]++;
                const randomIconClass = circleIcons[randomIconIndex];
    
                const icon = $('<i>').addClass('icon ' + randomIconClass).css({
                    left: x - 10,
                    top: y - 10,
                    color: '#000'
                });
                $(this).append(icon);
            }
        });
    }

    function highlightAlignedIcons() {
        const lineRect = line[0].getBoundingClientRect();
        const lineCenter = {
            x: lineRect.left + lineRect.width / 2,
            y: lineRect.top + lineRect.height / 2
        };

        circles.each(function (index) {
            const circleRect = this.getBoundingClientRect();
            const circleCenter = {
                x: circleRect.left + circleRect.width / 2,
                y: circleRect.top + circleRect.height / 2
            };

            $(this).find('.icon').removeClass('aligned').css('color', '');
            
            $(this).find('.icon').each(function () {
                const iconRect = this.getBoundingClientRect();
                const iconCenter = {
                    x: iconRect.left + iconRect.width / 2,
                    y: iconRect.top + iconRect.height / 2
                };

                // Check if the icon is close to the line
                const distanceToLine = Math.abs((lineCenter.y - circleCenter.y) * (iconCenter.x - circleCenter.x) - 
                                                (lineCenter.x - circleCenter.x) * (iconCenter.y - circleCenter.y)) /
                                       Math.sqrt(Math.pow(lineCenter.y - circleCenter.y, 2) + Math.pow(lineCenter.x - circleCenter.x, 2));

                if (distanceToLine < 10) { // Adjust this threshold as needed
                    $(this).addClass('aligned');
                    currentAttempt[index] = $(this).attr('class').split(' ').find(cls => cls.startsWith('fa-'));
                }
            });
        });

        checkSolution();
        checkSolutionIcons();
    }

    function rotateCircle(circle, direction) {
        let rotation = parseFloat($(circle).attr('data-rotation') || 0);
        const rotationIncrement = 5;
        rotation += direction * rotationIncrement;
        
        $(circle).attr('data-rotation', rotation);
        $(circle).css('transform', `rotate(${rotation}deg)`);

        // Update background position
        let bgPosition = $(circle).css('background-position').split(' ');
        let bgX = parseFloat(bgPosition[0]);
        let bgY = parseFloat(bgPosition[1]);
        const bgIncrement = rotationIncrement * 0.1;
        bgX -= direction * bgIncrement;
        bgY -= direction * bgIncrement;
        $(circle).css('background-position', `${bgX}px ${bgY}px`);
        
        highlightAlignedIcons();
    }

    function checkSolutionIcons() {
        circles.each(function (index) {
            const rotation = parseInt($(this).attr('data-rotation')) || 0;
            const solutionIcon = $(this).find('.solution-icon');
            if (solutionIcon.length > 0) {
                const iconAngle = (Math.atan2(
                    solutionIcon.position().top - $(this).height() / 2,
                    solutionIcon.position().left - $(this).width() / 2
                ) * (180 / Math.PI) + 360) % 360;
                
                // Check if the solution icon is at the 0-degree line (right side, allowing for some margin)
                if (Math.abs(iconAngle) < 10 || Math.abs(iconAngle - 360) < 10) {
                    solutionIcon.css('color', '#ff0000'); // Change to red when aligned
                } else {
                    solutionIcon.css('color', '#000'); // Reset to black when not aligned
                }
            }
        });
    }

    function checkSolution() {
        let solved = true;
        circles.each(function (index) {
            const solutionIcon = $(this).find('.solution-icon');
            if (solutionIcon.length === 0 || solutionIcon.css('color') !== 'rgb(255, 0, 0)') {
                solved = false;
                return false;
            }
        });

        if (solved) {
            alert('Puzzle solved! Congratulations!');
            // Uncomment the line below to redirect to another page
            // window.location.href = 'next-page.html';
        }
    }

    circles.click(function () {
        circles.removeClass('selected');
        $(this).addClass('selected');
        selectedCircle = this;
    });

    $('#up-btn, #down-btn').click(function () {
        if (selectedCircle) {
            rotateCircle(selectedCircle, $(this).attr('id') === 'up-btn' ? -1 : 1);
        }
    });

    setBackgroundImages();
    addIcons();
    highlightAlignedIcons(); // Initial check
});