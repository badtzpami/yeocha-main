<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Circular Progress Bar</title>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .progress-circle {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }

        .progress-value {
            position: absolute;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .progress-ring {
            position: absolute;
            transform: rotate(-90deg);
        }

        .progress-ring__circle {
            transition: stroke-dasharray 0.5s;
            stroke-dasharray: 0 327;
            stroke-linecap: round;
        }

        circle {
            stroke: darkred;
        }
    </style>
</head>

<body>
    <div class="progress-circle">
        <span class="progress-value">0%</span>
        <svg class="progress-ring" width="150" height="150">
            <circle class="progress-ring__circle" stroke-width="10" fill="transparent" r="70" cx="75" cy="75" />
        </svg>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Check if animation has already been done
            if (localStorage.getItem('progressAnimationDone')) {
                document.querySelector('.progress-circle').style.display = 'none';
                return;
            }

            let circle = document.querySelector('.progress-ring__circle');
            let valueText = document.querySelector('.progress-value');

            // Total circumference of the circle
            const radius = circle.r.baseVal.value;
            const circumference = 2 * Math.PI * radius;

            circle.style.strokeDasharray = `${circumference} ${circumference}`;

            let progress = 0;
            let interval = setInterval(() => {
                progress += 1;
                if (progress > 99) {
                    clearInterval(interval);
                    // Save to localStorage when animation is done
                    localStorage.setItem('progressAnimationDone', true);
                }

                const offset = circumference - (progress / 100) * circumference;
                circle.style.strokeDasharray = `${circumference - offset} ${circumference}`;
                valueText.textContent = `${progress}%`;
            }, 70);
        });
    </script>
</body>

</html>
