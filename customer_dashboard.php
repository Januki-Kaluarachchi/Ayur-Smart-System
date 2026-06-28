<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer | Ayur-Smart</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { margin: 0; padding: 0; overflow: hidden; background-color: #081c15; color: #d8f3dc; font-family: sans-serif; }
        .dashboard-container { position: relative; z-index: 1; text-align: center; margin-top: 50px; }
        .service-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; padding: 50px; justify-items: center; }
        .service-card { background: rgba(255, 255, 255, 0.05); padding: 40px; border-radius: 20px; text-align: center; border: 1px solid #b7e4c7; color: #d8f3dc; text-decoration: none; transition: 0.3s; width: 200px; }
        .service-card:hover { background: #2d6a4f; transform: scale(1.05); }
        #canvas { position: absolute; top: 0; left: 0; z-index: 0; }
        .logout-btn { display: inline-block; margin-top: 20px; padding: 12px 30px; background-color: #d8f3dc; color: #081c15; border: none; border-radius: 25px; text-decoration: none; font-weight: bold; transition: 0.3s; cursor: pointer; }
        .logout-btn:hover { background-color: #ff6b6b; color: white; transform: scale(1.05); }
    </style>
</head>
<body>

    <canvas id="canvas"></canvas>

    <div class="dashboard-container">
        <h1>ආයුබෝවන්, <?php echo $_SESSION['username']; ?>!</h1>
        <p>ඔබට අවශ්‍ය සේවාව තෝරන්න</p>

        <div class="service-grid">
            <a href="pharmacy_shop.php" class="service-card">
                <h2>Pharmacy</h2>
                <p>ඔසුසල</p>
            </a>
            <a href="salon_therapy.php" class="service-card">
                <h2>Salon</h2>
                <p>සැලෝන් (Therapy)</p>
            </a>
            <a href="channeling_doctors.php" class="service-card">
                <h2>Channeling</h2>
                <p>වෛද්‍ය උපදෙස්</p>
            </a>
        </div>

        <a href="logout.php" class="logout-btn">Logout (පිටවීම)</a>
    </div>

    <script>
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let particles = [];
        class Leaf {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 15 + 10;
                this.speedX = Math.random() * 1 - 0.5;
                this.speedY = Math.random() * 1 + 0.5;
                this.color = '#40916c';
            }
            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                if (this.y > canvas.height) this.y = -this.size;
            }
            draw() {
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.ellipse(this.x, this.y, this.size, this.size/2, Math.PI/4, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function init() {
            for (let i = 0; i < 30; i++) particles.push(new Leaf());
        }
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => { p.update(); p.draw(); });
            requestAnimationFrame(animate);
        }
        init();
        animate();
    </script>
</body>
</html>