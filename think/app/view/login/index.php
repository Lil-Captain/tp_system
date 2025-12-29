<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录</title>
    <style>
        /* 全局样式重置 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* 登录容器 */
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 50px 40px;
            width: 100%;
            max-width: 420px;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 标题 */
        .login-title {
            text-align: center;
            font-size: 32px;
            font-weight: 600;
            color: #1d1d1f;
            margin-bottom: 40px;
            letter-spacing: -0.5px;
        }

        /* 表单组 */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #1d1d1f;
            margin-bottom: 8px;
        }

        /* 输入框样式 */
        .form-input {
            width: 100%;
            padding: 14px 16px;
            font-size: 16px;
            border: 2px solid #e5e5e7;
            border-radius: 12px;
            background: #ffffff;
            color: #1d1d1f;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-input::placeholder {
            color: #86868b;
        }

        /* 验证码容器 */
        .captcha-group {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }

        .captcha-input {
            flex: 1;
        }

        .captcha-image {
            width: 120px;
            height: 48px;
            border: 2px solid #e5e5e7;
            border-radius: 12px;
            cursor: pointer;
            background: #f5f5f7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #86868b;
            transition: all 0.3s ease;
        }

        .captcha-image:hover {
            border-color: #667eea;
            background: #f0f0f2;
        }

        .captcha-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        /* 记住密码容器 */
        .remember-group {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .remember-checkbox {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .remember-label {
            font-size: 14px;
            color: #1d1d1f;
            cursor: pointer;
            user-select: none;
        }

        /* 提交按钮 */
        .submit-btn {
            width: 100%;
            padding: 16px;
            font-size: 17px;
            font-weight: 600;
            color: #ffffff;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* 错误提示 */
        .error-message {
            background: #ff3b30;
            color: #ffffff;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 20px;
            display: none;
            animation: shake 0.5s ease;
        }

        .error-message.show {
            display: block;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* 响应式设计 */
        @media (max-width: 480px) {
            .login-container {
                padding: 40px 30px;
            }

            .login-title {
                font-size: 28px;
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">用户登录</h1>
        
        <!-- 错误提示区域 -->
        <div id="errorMessage" class="error-message"></div>

        <!-- 登录表单 -->
        <form id="loginForm">
            <!-- 账号输入 -->
            <div class="form-group">
                <label class="form-label" for="account">账号</label>
                <input 
                    type="text" 
                    id="account" 
                    name="account" 
                    class="form-input" 
                    placeholder="请输入您的账号"
                    required
                    autocomplete="account"
                >
            </div>

            <!-- 密码输入 -->
            <div class="form-group">
                <label class="form-label" for="password">密码</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="请输入您的密码"
                    required
                    autocomplete="current-password"
                >
            </div>

            <!-- 验证码输入 -->
            <div class="form-group">
                <label class="form-label" for="captcha">验证码</label>
                <div class="captcha-group">
                    <input 
                        type="text" 
                        id="captcha" 
                        name="captcha" 
                        class="form-input captcha-input" 
                        placeholder="请输入验证码"
                        required
                        maxlength="4"
                    >
                    <div class="captcha-image" id="captchaImage" onclick="refreshCaptcha()" title="点击刷新验证码">
                        <img src="{:captcha_src()}" id="captcha-img">
                    </div>
                </div>
            </div>

            <!-- 记住密码 -->
            <div class="remember-group">
                <input 
                    type="checkbox" 
                    id="remember" 
                    name="remember" 
                    class="remember-checkbox"
                    value="1"
                >
                <label class="remember-label" for="remember">记住密码</label>
            </div>

            <!-- 提交按钮 -->
            <button type="button" class="submit-btn" id="submitBtn" onclick="login()">
                登录
            </button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script >
        function login(){
            $.post("/login/dologin", $("#loginForm").serialize(), function(res){
                if (res.code == 0){
                    window.location.href = "/admin/dashboard/index"
                }else{
                    showError(res.msg || res.message || '登录失败，请检查账号密码');
                        // 刷新验证码
                        refreshCaptcha();
                        // 清空验证码输入框
                        document.getElementById('captcha').value = '';
                }
            }, "json")
        }
        function refreshCaptcha(){
            $("#captcha-img").attr("src", "{:captcha_src()}?rand="+Math.random())
        }

        // 显示错误信息
        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.classList.add('show');
            // 3秒后自动隐藏
            setTimeout(() => {
                errorMessage.classList.remove('show');
            }, 3000);
        }

        // // 刷新验证码
        refreshCaptcha()

        // 输入框获得焦点时清除错误提示
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                errorMessage.classList.remove('show');
            });
        });
    </script>
</body>
</html>
