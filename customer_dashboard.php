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
    <title>Customer Portal | Ayur-Smart</title>
    <style>
        body { margin: 0; padding: 0; overflow: hidden; background-color: #081c15; color: #d8f3dc; font-family: 'Segoe UI', sans-serif; }
        
        .header-nav { position: absolute; top: 25px; right: 40px; z-index: 10; }
        .logout-btn { 
            padding: 15px 30px; background-color: #d8f3dc; color: #081c15; 
            border: none; border-radius: 30px; text-decoration: none; 
            font-weight: bold; font-size: 1.2rem; transition: 0.3s; cursor: pointer; 
        }
        .logout-btn:hover { background-color: #ff6b6b; color: white; }

        .dashboard-container { position: relative; z-index: 1; text-align: center; margin-top: 60px; }
        
        h1 { font-size: 3rem; margin-bottom: 10px; }
        p { font-size: 1.5rem; margin-bottom: 40px; }
        

        .service-grid { 
            display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 40px; padding: 20px; max-width: 1100px; margin: 0 auto; 
        }
        .service-card { 
            background: rgba(255, 255, 255, 0.08); padding: 50px; border-radius: 30px; 
            text-align: center; border: 2px solid #b7e4c7; color: #d8f3dc; 
            text-decoration: none; transition: 0.4s; 
        }
        .service-card:hover { background: #2d6a4f; transform: scale(1.05); border-color: #ffffff; }
        
        .service-card h2 { font-size: 2.5rem; margin: 0; }
        .service-card p { font-size: 1.8rem; margin-top: 10px; }
        
        #canvas { position: absolute; top: 0; left: 0; z-index: 0; }
    </style>
</head>
<body>

    <canvas id="canvas"></canvas>

    <div class="header-nav">
        <a href="logout.php" class="logout-btn">Logout (පිටවීම)</a>
    </div>

    <div class="dashboard-container">
        <h1>ආයුබෝවන්, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>ඔබට අවශ්‍ය සේවාව තෝරන්න</p>

        <div class="service-grid">
            <a href="pharmacy_shop.php" class="service-card">
                <h2>Pharmacy</h2><p>ඔසුසල</p>
            </a>
            <a href="salon_therapy.php" class="service-card">
                <h2>Salon</h2><p>සැලෝන් (Therapy)</p>
            </a>
            <a href="channeling_doctors.php" class="service-card">
                <h2>Channeling</h2><p>වෛද්‍ය උපදෙස්</p>
            </a>
        </div>
      
       <div style="text-align: center; margin-top: 30px;">
      <a href="https://wa.me/94710665979?text=Hello%20Ayur-Smart,%20I%20want%20to%20upload%20my%20prescription%20for%20medicine." 
       target="_blank" 
       style="background-color: #25D366; color: white; padding: 12px 25px; font-size: 16px; font-weight: bold; text-decoration: none; border-radius: 30px; box-shadow: 0px 4px 10px rgba(0,0,0,0.2); display: inline-flex; align-items: center; gap: 10px; transition: 0.3s;">
        <i class="fab fa-whatsapp" style="font-size: 20px;"></i> Upload Prescription (WhatsApp)
    </a>
     </div>
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
                this.size = Math.random() * 20 + 15;
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
            for (let i = 0; i < 25; i++) particles.push(new Leaf());
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