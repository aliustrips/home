<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUSY RIDE - Ride in Style, Anytime, Anywhere</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* ... all CSS from index.php ... */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            z-index: 1000;
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(15, 23, 42, 0.98);
            padding: 10px 0;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Poppins', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: #10b981;
            text-decoration: none;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 40px;
        }

        .nav-links a {
            color: #f8fafc;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: #10b981;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #10b981, #3b82f6);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .download-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.8), rgba(30, 41, 59, 0.7)), 
                        url('https://images.unsplash.com/photo-1449824913935-59a10b8d2000?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 70%, rgba(16, 185, 129, 0.1), transparent 50%),
                        radial-gradient(circle at 70% 30%, rgba(59, 130, 246, 0.1), transparent 50%);
            animation: pulse 6s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-text h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 4.5rem;
            font-weight: 800;
            color: #f8fafc;
            margin-bottom: 24px;
            line-height: 1.1;
            opacity: 0;
            animation: fadeInUp 1s ease 0.3s forwards;
        }

        .hero-text .highlight {
            background: linear-gradient(135deg, #10b981, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 300% 300%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .hero-text p {
            font-size: 1.25rem;
            color: #cbd5e1;
            margin-bottom: 40px;
            max-width: 500px;
            opacity: 0;
            animation: fadeInUp 1s ease 0.6s forwards;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
            opacity: 0;
            animation: fadeInUp 1s ease 0.9s forwards;
        }

        .cta-primary {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 18px 36px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .cta-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .cta-primary:hover::before {
            left: 100%;
        }

        .cta-primary:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
        }

        .cta-secondary {
            background: transparent;
            color: #f8fafc;
            border: 2px solid #3b82f6;
            padding: 16px 34px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .cta-secondary:hover {
            background: #3b82f6;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(59, 130, 246, 0.3);
        }

        /* Booking Widget */
        .booking-widget {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            opacity: 0;
            animation: fadeInRight 1s ease 1.2s forwards;
        }

        .widget-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 30px;
            text-align: center;
        }

        .ride-options {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .ride-option {
            flex: 1;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .ride-option.active {
            border-color: #10b981;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(59, 130, 246, 0.05));
            transform: scale(1.02);
        }

        .ride-option i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #64748b;
            transition: color 0.3s ease;
        }

        .ride-option.active i {
            color: #10b981;
        }

        .ride-option h4 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .ride-option p {
            font-size: 0.9rem;
            color: #64748b;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-group input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .input-group input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .book-btn {
            width: 100%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 18px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
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

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Features Section */
        .features {
            padding: 120px 0;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            position: relative;
            overflow: hidden;
        }

        .features::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(16, 185, 129, 0.03), transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.03), transparent 50%);
        }

        .section-header {
            text-align: center;
            margin-bottom: 80px;
            position: relative;
            z-index: 2;
        }

        .section-header h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .section-header p {
            font-size: 1.2rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            position: relative;
            z-index: 2;
        }

        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.4s ease;
            border: 1px solid rgba(16, 185, 129, 0.1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #3b82f6);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2rem;
            color: white;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-card h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #64748b;
            line-height: 1.6;
        }

        /* Testimonials */
        .testimonials {
            padding: 120px 0;
            background: linear-gradient(135deg, #1e293b, #334155);
            position: relative;
            overflow: hidden;
        }

        .testimonials::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.02)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }

        .testimonials .section-header h2 {
            color: white;
        }

        .testimonials .section-header p {
            color: #cbd5e1;
        }

        .testimonials-slider {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 40px;
            position: relative;
            z-index: 2;
        }

        .testimonial-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
        }

        .stars {
            color: #fbbf24;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .testimonial-text {
            color: #e2e8f0;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 25px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .author-info h4 {
            color: white;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .author-info p {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* App Download Section */
        .app-download {
            padding: 120px 0;
            background: linear-gradient(135deg, #f8fafc, #ffffff);
            position: relative;
        }

        .download-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .download-text h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 25px;
            line-height: 1.2;
        }

        .download-text p {
            font-size: 1.2rem;
            color: #64748b;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .app-badges {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .app-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #1e293b;
            color: white;
            padding: 15px 25px;
            border-radius: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .app-badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(30, 41, 59, 0.3);
            border-color: #10b981;
        }

        .app-badge i {
            font-size: 2rem;
        }

        .badge-text span {
            display: block;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .badge-text strong {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .phone-mockup {
            position: relative;
            text-align: center;
        }

        .phone-mockup img {
            max-width: 300px;
            height: auto;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        /* Footer */
        .footer {
            background: #0f172a;
            color: white;
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 40px;
        }

        .footer-brand h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
        }

        .footer-brand p {
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #10b981;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: #10b981;
            color: white;
            transform: translateY(-3px);
        }

        .footer-section h4 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            margin-bottom: 20px;
            color: white;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #10b981;
        }

        .footer-bottom {
            border-top: 1px solid #334155;
            padding-top: 30px;
            text-align: center;
            color: #64748b;
        }

        /* Mobile Hamburger */
        .mobile-menu {
            display: none;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
        }

        .mobile-menu span {
            width: 25px;
            height: 3px;
            background: white;
            transition: all 0.3s ease;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu {
                display: flex;
            }

            .hero-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 3rem;
            }

            .hero-buttons {
                justify-content: center;
                flex-wrap: wrap;
            }

            .download-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .app-badges {
                justify-content: center;
                flex-wrap: wrap;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .testimonials-slider {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .hero-text h1 {
                font-size: 2.5rem;
            }

            .section-header h2 {
                font-size: 2.2rem;
            }

            .download-text h2 {
                font-size: 2.2rem;
            }

            .booking-widget {
                padding: 25px;
            }

            .ride-options {
                flex-direction: column;
            }
        }

        /* Auth Buttons */
.auth-buttons {
    display: flex;
    gap: 15px;
    margin-right: 20px;
}

.login-btn {
    color: #f8fafc;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.login-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.3);
}

.register-btn {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.register-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
}

/* Mobile responsive adjustments */
@media (max-width: 992px) {
    .auth-buttons {
        display: none;
    }
}

@media (max-width: 992px) {
    .nav-links {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 80px;
        left: 0;
        right: 0;
        background: rgba(15, 23, 42, 0.98);
        padding: 20px;
        gap: 15px;
    }
    
    .nav-links.active {
        display: flex;
    }
    
    .nav-links li {
        padding: 10px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .mobile-auth {
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
}
/* Auth Modals */
.auth-modal {
    max-width: 450px;
    padding: 40px;
}

.auth-modal h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #1e293b;
}

.auth-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.auth-submit-btn {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 15px;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.auth-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
}

.auth-footer {
    text-align: center;
    margin-top: 20px;
    font-size: 0.9rem;
    color: #64748b;
}

.auth-footer a {
    color: #3b82f6;
    text-decoration: none;
}

.switch-auth {
    font-weight: 600;
}

.forgot-password {
    display: block;
    margin-top: 10px;
}

/* Auth Modals */
.auth-modal {
    max-width: 450px;
    padding: 40px;
}

.auth-modal h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #1e293b;
}

.auth-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.auth-submit-btn {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 15px;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.auth-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
}

.auth-footer {
    text-align: center;
    margin-top: 20px;
    font-size: 0.9rem;
    color: #64748b;
}

.auth-footer a {
    color: #3b82f6;
    text-decoration: none;
}

.switch-auth {
    font-weight: 600;
}

.forgot-password {
    display: block;
    margin-top: 10px;
}
    </style>
</head>
<body>
<nav class="navbar" id="navbar">
    <div class="container">
        <div class="nav-content">
            <a href="home.php" class="logo">BUSY RIDE</a>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="features.php">Features</a></li>
                <li><a href="reviews.php">Reviews</a></li>
                <li><a href="download.php">Download</a></li>
                <li><a href="about_us.php">About Us</a></li>
            </ul>
            <div class="auth-buttons">
                <a href="login.php" class="login-btn">Log In</a>
                <a href="register.php" class="register-btn">Register</a>
            </div>
            <a href="download.php" class="download-btn">Get App</a>
            <div class="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</nav> 