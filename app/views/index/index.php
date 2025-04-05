<?php
// PHP代码开始
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <!-- HTML头部信息 -->
    
    <meta charset="UTF-8">
    <title>我的PHP网站首页</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header, footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em 0;
        }
        main {
            padding: 2em;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h4>欢迎来到我的PHP网站</h4>
        <p>当前时间：<?php echo date('Y-m-d H:i:s'); ?></p>
    </header>
    
    <main>
        <?php
        if (isset($_SESSION['username'])) {
            echo '<p>欢迎, ' . htmlspecialchars($_SESSION['username']) . '!</p>';
        } else {
            echo '<p>请[登录](login.php)以享受更多功能。</p>';
        }
        
        ?>
    </main>
    
    <footer>
        <p>&copy; 2025 我的PHP网站. 保留所有权利.</p>
    </footer>
</body>
</html>
<?php
// PHP代码结束
?>