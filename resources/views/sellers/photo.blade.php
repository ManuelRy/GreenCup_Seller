@extends('master')

@section('content')
@php
    // Helper function to get the correct photo URL
    function getPhotoUrl($photo) {
        $url = $photo->photo_url;
        
        // If URL already starts with /storage, use it as is
        if (str_starts_with($url, '/storage/')) {
            return $url;
        }
        
        // If it's a full URL, use it as is
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }
        
        // If it starts with /, assume it's a full path
        if (str_starts_with($url, '/')) {
            return $url;
        }
        
        // Otherwise, assume it's just a filename and prepend the path
        return '/storage/seller_photos/' . $url;
    }
@endphp

<!-- Animated Background -->
<div class="background-animation"></div>
<div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
</div>
<div class="particles">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
</div>

<div class="container">
    <style>
        /* Base Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* Animated Background */
        .background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(45deg, #2E8B57, #3CB371, #98FB98, #32CD32, #228B22);
            background-size: 500% 500%;
            animation: liveGradient 4s ease infinite;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            animation: liveFloat 8s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            left: 15%;
            top: 20%;
            background: radial-gradient(circle, rgba(255,255,255,0.2), rgba(255,255,255,0.05));
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            right: 20%;
            top: 30%;
            background: radial-gradient(circle, rgba(255,255,255,0.15), rgba(255,255,255,0.03));
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 80px;
            height: 80px;
            left: 50%;
            top: 60%;
            background: radial-gradient(circle, rgba(255,255,255,0.18), rgba(255,255,255,0.04));
            animation-delay: 4s;
        }

        .shape:nth-child(4) {
            width: 120px;
            height: 120px;
            right: 10%;
            bottom: 30%;
            background: radial-gradient(circle, rgba(255,255,255,0.12), rgba(255,255,255,0.02));
            animation-delay: 6s;
        }

        .shape:nth-child(5) {
            width: 40px;
            height: 40px;
            left: 80%;
            top: 70%;
            background: radial-gradient(circle, rgba(255,255,255,0.25), rgba(255,255,255,0.08));
            animation-delay: 1s;
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: particleFloat 12s linear infinite;
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 4s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 6s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 8s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 1s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 3s; }
        .particle:nth-child(8) { left: 80%; animation-delay: 5s; }
        .particle:nth-child(9) { left: 90%; animation-delay: 7s; }

        @keyframes liveGradient {
            0% { background-position: 0% 50%; }
            25% { background-position: 100% 0%; }
            50% { background-position: 100% 100%; }
            75% { background-position: 0% 100%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes liveFloat {
            0%, 100% { 
                transform: translateY(0px) translateX(0px) rotate(0deg) scale(1); 
                opacity: 0.7;
            }
            25% { 
                transform: translateY(-40px) translateX(20px) rotate(90deg) scale(1.1); 
                opacity: 1;
            }
            50% { 
                transform: translateY(-80px) translateX(-10px) rotate(180deg) scale(0.9); 
                opacity: 0.8;
            }
            75% { 
                transform: translateY(-120px) translateX(30px) rotate(270deg) scale(1.2); 
                opacity: 0.6;
            }
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) translateX(0px);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) translateX(50px);
                opacity: 0;
            }
        }

        .container {
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            min-height: 100vh;
            position: relative;
            backdrop-filter: blur(10px);
            border-radius: 0 0 25px 25px;
            overflow: hidden;
        }

        @media (min-width: 768px) {
            .container {
                max-width: 900px;
                margin: 20px auto;
                border-radius: 25px;
                box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            }
        }

        @media (min-width: 1024px) {
            .container {
                max-width: 900px;
                transform: scale(1.1);
            }
        }

        @media (max-width: 480px) {
            .container {
                max-width: 100%;
                margin: 0;
                border-radius: 0;
            }
        }

        /* Photo Page Styles */
        .photo-page-container {
            padding: 20px;
            max-width: 900px;
            margin: 0 auto;
        }

        .photo-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 30px 20px 20px 20px;
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .back-button {
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(46, 139, 87, 0.3);
            position: relative;
            z-index: 10;
            margin-right: auto;
            order: 1;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(46, 139, 87, 0.4);
            color: white;
            text-decoration: none;
        }

        .header-title-section {
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            order: 2;
        }

        .photo-page-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #2E8B57;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .photo-page-subtitle {
            font-size: 16px;
            opacity: 0.9;
            color: #2E8B57;
            font-weight: 500;
        }

        /* Facebook-style Post Creator */
        .post-creator {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .post-header {
            padding: 20px 20px 0 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: bold;
        }

        .user-details h3 {
            font-size: 16px;
            font-weight: 600;
            color: #2E8B57;
            margin-bottom: 2px;
        }

        .user-details p {
            font-size: 13px;
            color: #65676b;
        }

        .post-input {
            width: 100%;
            border: none;
            padding: 16px 0;
            font-size: 16px;
            color: #2E8B57;
            resize: none;
            min-height: 80px;
            font-family: inherit;
        }

        .post-input:focus {
            outline: none;
        }

        .post-input::placeholder {
            color: #8a8d91;
        }

        /* Photo Upload Section */
        .photo-section {
            padding: 0 20px 20px 20px;
        }

        .upload-area {
            border: 2px dashed #2E8B57;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            background: #E8F5E8;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .upload-area:hover {
            border-color: #228B22;
            background: #E0F0E0;
        }

        .upload-area.dragover {
            border-color: #228B22;
            background: #E0F0E0;
        }

        .upload-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.6;
        }

        .upload-text {
            font-size: 16px;
            color: #2E8B57;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .upload-subtext {
            font-size: 14px;
            color: #65676b;
        }

        .file-input {
            display: none;
        }

        /* Photo Preview Grid */
        .photo-preview-grid {
            display: none;
            grid-gap: 8px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .photo-preview-grid.single {
            display: grid;
            grid-template-columns: 1fr;
        }

        .photo-preview-grid.two {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .photo-preview-grid.three {
            display: grid;
            grid-template-columns: 2fr 1fr;
            grid-template-rows: 1fr 1fr;
            height: 300px;
        }

        .photo-preview-grid.four-plus {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            height: 300px;
        }

        .photo-item {
            position: relative;
            background: #f0f0f0;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 1;
            cursor: pointer;
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .photo-item:hover img {
            transform: scale(1.05);
        }

        .photo-item.large {
            grid-row: span 2;
            aspect-ratio: auto;
        }

        .photo-overlay {
            position: absolute;
            top: 8px;
            right: 8px;
            display: flex;
            gap: 4px;
        }

        .overlay-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.6);
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .overlay-btn:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: scale(1.1);
        }

        .more-photos {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }

        /* Options Panel */
        .options-panel {
            background: #f7f8fa;
            padding: 16px 20px;
            border-top: 1px solid #f0f0f0;
            display: none;
        }

        .options-panel.active {
            display: block;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #2E8B57;
        }

        .checkbox-group label {
            color: #2E8B57;
            font-weight: 500;
        }

        /* Action Buttons */
        .post-actions {
            display: flex;
            gap: 8px;
            padding: 12px 16px;
            border-top: 1px solid #f0f0f0;
            background: #f7f8fa;
        }

        .action-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border: none;
            background: transparent;
            color: #2E8B57;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background: #e4e6ea;
        }

        .action-btn.active {
            background: #E8F5E8;
            color: #2E8B57;
        }

        .post-btn {
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            color: white;
            padding: 12px 32px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 16px;
            width: 100%;
            box-shadow: 0 4px 15px rgba(46, 139, 87, 0.3);
        }

        .post-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(46, 139, 87, 0.4);
        }

        .post-btn:disabled {
            background: #e4e6ea;
            color: #bcc0c4;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Gallery Section */
        .existing-photos {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #2E8B57;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .photo-posts-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .photo-post {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        .photo-post-grid {
            display: grid;
            gap: 4px;
        }

        .photo-post-grid.single {
            grid-template-columns: 1fr;
        }

        /* Error state for images */
        .gallery-photo-item.img-error::before {
            opacity: 1;
            color: #ccc;
        }
        
        /* Fix aspect ratios for different layouts */
        .photo-post-grid.single .gallery-photo-item {
            aspect-ratio: 4/3;
            max-height: 500px;
            position: relative;
        }

        .photo-post-grid.two .gallery-photo-item {
            height: 100%;
            position: relative;
        }

        .photo-post-grid.three .gallery-photo-item {
            height: 100%;
            position: relative;
        }
        
        .photo-post-grid.three .gallery-photo-item.large {
            grid-row: 1 / 3;
            height: 100%;
        }

        .photo-post-grid.four-plus .gallery-photo-item {
            height: 100%;
            position: relative;
        }

        .photo-post-grid.two {
            grid-template-columns: 1fr 1fr;
            height: 300px;
        }

        .photo-post-grid.three {
            grid-template-columns: 2fr 1fr;
            grid-template-rows: 1fr 1fr;
            height: 400px;
        }

        .photo-post-grid.four-plus {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            height: 400px;
        }

        .gallery-photo-item {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            background: #f0f0f0;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-photo-item.large {
            grid-row: 1 / 3;
        }

        .gallery-photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        /* Fallback for broken images */
        .gallery-photo-item img[src=""],
        .gallery-photo-item img:not([src]),
        .gallery-photo-item img[src*="undefined"] {
            display: none;
        }
        
        .gallery-photo-item::before {
            content: "📷";
            font-size: 48px;
            opacity: 0.3;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        .gallery-photo-item:hover img {
            transform: scale(1.05);
        }

        .gallery-photo-overlay {
            position: absolute;
            top: 8px;
            right: 8px;
            display: flex;
            gap: 4px;
            opacity: 0;
            transition: opacity 0.2s ease;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), transparent);
            padding: 8px;
            border-radius: 8px;
        }

        .gallery-photo-item:hover .gallery-photo-overlay {
            opacity: 1;
        }

        .gallery-overlay-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.7);
            border: none;
            color: white;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .gallery-overlay-btn:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: scale(1.1);
        }

        .gallery-more-photos {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
        }

        .featured-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: white;
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .photo-post-info {
            padding: 12px 16px;
            background: #f9f9f9;
            border-top: 1px solid #e0e0e0;
        }

        .post-meta {
            font-size: 12px;
            color: #65676b;
            margin-bottom: 8px;
        }

        .post-caption {
            font-size: 14px;
            color: #1d2129;
            line-height: 1.4;
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #E8F5E8;
            color: #2E8B57;
            border: 1px solid #2E8B57;
        }

        .alert-error {
            background: #ffebee;
            color: #e41e3f;
            border: 1px solid #e41e3f;
        }

        /* Progress Indicator */
        .upload-progress {
            text-align: center;
            margin-top: 10px;
            color: #2E8B57;
            font-weight: 600;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-title {
            margin-bottom: 20px;
            color: #2E8B57;
            font-size: 24px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            color: #2E8B57;
            font-weight: 600;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-primary {
            flex: 1;
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-secondary {
            flex: 1;
            background: #e4e6ea;
            color: #65676b;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        /* Lightbox */
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            cursor: pointer;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }

        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .photo-page-container {
                padding: 10px;
            }

            .photo-page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .header-title-section {
                position: static;
                transform: none;
                order: -1;
            }

            .photo-page-title {
                font-size: 24px;
            }

            .photo-preview-grid.three,
            .photo-preview-grid.four-plus,
            .photo-post-grid.three,
            .photo-post-grid.four-plus {
                grid-template-columns: 1fr 1fr;
                height: 250px;
            }

            .photo-post-grid.single {
                max-height: 400px;
            }
        }

        /* Animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .photo-item, .gallery-photo-item {
            animation: slideIn 0.3s ease;
        }
    </style>

    <div class="photo-page-container">
        <!-- Header -->
        <div class="photo-page-header">
            <a href="{{ route('dashboard') }}" class="back-button">
                ← Back to Dashboard
            </a>
            <div class="header-title-section">
                <h1 class="photo-page-title">📸 Store Gallery Manager</h1>
                <p class="photo-page-subtitle">Share your store photos with customers</p>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    ❌ {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <!-- Post Creator -->
        <div class="post-creator">
            <div class="post-header">
                <div class="user-info">
                    <div class="avatar">
                        {{ substr($seller->business_name, 0, 1) }}
                    </div>
                    <div class="user-details">
                        <h3>{{ $seller->business_name }}</h3>
                        <p>📍 {{ $seller->address }}</p>
                    </div>
                </div>
                <textarea 
                    class="post-input" 
                    placeholder="What's new in your store today? Share photos and tell customers about your latest products or updates..."
                    id="captionInput"
                ></textarea>
            </div>

            <div class="photo-section">
                <!-- Upload Area -->
                <div class="upload-area" onclick="triggerFileInput()" id="dropArea">
                    <div class="upload-icon">📸</div>
                    <div class="upload-text">Add photos to your post</div>
                    <div class="upload-subtext">Drag and drop or click to select photos</div>
                </div>
                <input type="file" id="photoInput" class="file-input" multiple accept="image/*">

                <!-- Photo Preview Grid -->
                <div id="photoGrid" class="photo-preview-grid">
                    <!-- Photos will be dynamically added here -->
                </div>

                <!-- Options Panel -->
                <div id="optionsPanel" class="options-panel">
                    <div class="checkbox-group">
                        <input type="checkbox" id="featuredCheck">
                        <label for="featuredCheck">⭐ Set as featured photos</label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="post-actions">
                <button class="action-btn" id="photoBtn" onclick="togglePhotoOptions()">
                    📷 Photo/Video
                </button>
                <button class="action-btn" onclick="addLocation()">
                    📍 Location
                </button>
                <button class="action-btn" onclick="addTag()">
                    🏷️ Tag Products
                </button>
            </div>

            <div style="padding: 0 20px 20px;">
                <button class="post-btn" onclick="publishPost()" disabled>
                    Share Photos
                </button>
                <div id="uploadProgress" class="upload-progress" style="display: none;"></div>
            </div>
        </div>

        <!-- Photo Gallery -->
        @if($photos->count() > 0)
        <div class="existing-photos">
            <h2 class="section-title">
                📸 Your Photo Gallery ({{ $photos->count() }} photos)
            </h2>
            <div class="photo-posts-container">
                @php
                    // Group photos by upload session (photos uploaded within 10 seconds of each other)
                    $groupedPhotos = collect();
                    $processedIds = collect();
                    
                    foreach($photos as $photo) {
                        if ($processedIds->contains($photo->id)) {
                            continue;
                        }
                        
                        // Find all photos uploaded within 10 seconds of this photo
                        $sessionPhotos = $photos->filter(function($p) use ($photo, $processedIds) {
                            return !$processedIds->contains($p->id) && 
                                   abs($photo->created_at->diffInSeconds($p->created_at)) <= 10;
                        });
                        
                        $groupedPhotos->push($sessionPhotos);
                        $processedIds = $processedIds->merge($sessionPhotos->pluck('id'));
                    }
                @endphp

                @foreach($groupedPhotos as $photoGroup)
                    <div class="photo-post">
                        <div class="photo-post-grid {{ count($photoGroup) == 1 ? 'single' : (count($photoGroup) == 2 ? 'two' : (count($photoGroup) == 3 ? 'three' : 'four-plus')) }}">
                            @foreach($photoGroup->take(4) as $index => $photo)
                                @php
                                    $photoUrl = getPhotoUrl($photo);
                                @endphp
                                <div class="gallery-photo-item {{ count($photoGroup) == 3 && $index == 0 ? 'large' : '' }}" 
                                     onclick="viewPhoto('{{ $photoUrl }}', event)"
                                     data-photo-url="{{ $photo->photo_url }}"
                                     data-processed-url="{{ $photoUrl }}">
                                    <img src="{{ $photoUrl }}" 
                                         alt="{{ $photo->caption ?: 'Store photo' }}"
                                         onerror="this.style.display='none'; this.parentElement.classList.add('img-error');">
                                    <div class="gallery-photo-overlay">
                                        <button class="gallery-overlay-btn" onclick="editPhoto({{ $photo->id }}, event)" title="Edit">✏️</button>
                                        <form action="{{ route('seller.photos.destroy', $photo->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this photo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="gallery-overlay-btn" onclick="event.stopPropagation();" title="Delete">🗑️</button>
                                        </form>
                                    </div>
                                    @if(count($photoGroup) > 4 && $index == 3)
                                        <div class="gallery-more-photos">+{{ count($photoGroup) - 4 }}</div>
                                    @endif
                                    @if($photo->is_featured)
                                        <div class="featured-badge">⭐ Featured</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="photo-post-info">
                            <div class="post-meta">
                                📅 {{ $photoGroup->first()->created_at->format('M j, Y g:i A') }} • 
                                {{ count($photoGroup) }} photo{{ count($photoGroup) > 1 ? 's' : '' }}
                                @if($photoGroup->where('is_featured', true)->count() > 0)
                                    • ⭐ Featured
                                @endif
                            </div>
                            @if($photoGroup->first()->caption)
                                <div class="post-caption">{{ $photoGroup->first()->caption }}</div>
                            @endif
                            <!-- Debug info - remove in production -->
                            <div style="font-size: 10px; color: #999; margin-top: 5px;">
                                Debug: {{ getPhotoUrl($photoGroup->first()) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @else
            <div class="existing-photos">
                <div style="text-align: center; padding: 40px; color: #65676b;">
                    <div style="font-size: 48px; margin-bottom: 20px;">📷</div>
                    <h3 style="margin-bottom: 10px; color: #2E8B57;">No photos yet</h3>
                    <p>Upload your first photo to start building your store gallery!</p>
                </div>
            </div>
        @endif
        
    </div>

    <script>
        let selectedFiles = [];
        let photoCounter = 0;

        // File input trigger
        function triggerFileInput() {
            document.getElementById('photoInput').click();
        }

        // Handle file selection
        document.getElementById('photoInput').addEventListener('change', function(e) {
            handleFiles(Array.from(e.target.files));
        });

        // Handle files (shared function)
        function handleFiles(files) {
            selectedFiles = []; // Clear previous selections
            photoCounter = 0;
            
            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    selectedFiles.push({
                        file: file,
                        id: ++photoCounter,
                        url: URL.createObjectURL(file)
                    });
                }
            });
            updatePhotoGrid();
            updatePostButton();
        }

        // Drag and drop
        const dropArea = document.getElementById('dropArea');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight(e) {
            dropArea.classList.add('dragover');
        }
        
        function unhighlight(e) {
            dropArea.classList.remove('dragover');
        }
        
        dropArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(Array.from(files));
        }

        // Update photo grid
        function updatePhotoGrid() {
            const grid = document.getElementById('photoGrid');
            const count = selectedFiles.length;

            if (count === 0) {
                grid.style.display = 'none';
                document.getElementById('dropArea').style.display = 'block';
                return;
            }

            document.getElementById('dropArea').style.display = 'none';
            grid.className = 'photo-preview-grid';

            if (count === 1) {
                grid.classList.add('single');
            } else if (count === 2) {
                grid.classList.add('two');
            } else if (count === 3) {
                grid.classList.add('three');
            } else {
                grid.classList.add('four-plus');
            }

            grid.innerHTML = '';

            selectedFiles.slice(0, count === 3 ? 3 : count > 4 ? 4 : count).forEach((photo, index) => {
                const photoDiv = document.createElement('div');
                photoDiv.className = 'photo-item';
                
                if (count === 3 && index === 0) {
                    photoDiv.classList.add('large');
                }

                photoDiv.innerHTML = `
                    <img src="${photo.url}" alt="Preview">
                    <div class="photo-overlay">
                        <button class="overlay-btn" onclick="removePhoto(${photo.id})" title="Remove">❌</button>
                    </div>
                    ${count > 4 && index === 3 ? `<div class="more-photos">+${count - 4}</div>` : ''}
                `;

                grid.appendChild(photoDiv);
            });

            grid.style.display = 'grid';
        }

        // Remove photo
        function removePhoto(photoId) {
            selectedFiles = selectedFiles.filter(photo => photo.id !== photoId);
            updatePhotoGrid();
            updatePostButton();
            
            if (selectedFiles.length === 0) {
                document.getElementById('dropArea').style.display = 'block';
            }
        }

        // Toggle photo options
        function togglePhotoOptions() {
            const panel = document.getElementById('optionsPanel');
            const btn = document.getElementById('photoBtn');
            
            if (panel.classList.contains('active')) {
                panel.classList.remove('active');
                btn.classList.remove('active');
            } else {
                panel.classList.add('active');
                btn.classList.add('active');
            }
        }

        // Update post button
        function updatePostButton() {
            const postBtn = document.querySelector('.post-btn');
            const hasPhotos = selectedFiles.length > 0;
            const hasText = document.getElementById('captionInput').value.trim().length > 0;
            
            postBtn.disabled = !(hasPhotos || hasText);
            
            if (hasPhotos) {
                postBtn.textContent = `Share ${selectedFiles.length} Photo${selectedFiles.length > 1 ? 's' : ''}`;
            } else {
                postBtn.textContent = 'Share Photos';
            }
        }

        document.getElementById('captionInput').addEventListener('input', updatePostButton);

        // Placeholder functions
        function addLocation() {
            alert('Location feature coming soon! 📍');
        }

        function addTag() {
            alert('Product tagging feature coming soon! 🏷️');
        }
        
        // Debug photo URLs on page load
        document.addEventListener('DOMContentLoaded', function() {
            const photoItems = document.querySelectorAll('.gallery-photo-item');
            console.log('Total photos found:', photoItems.length);
            
            // Check first photo to debug
            if (photoItems.length > 0) {
                const firstItem = photoItems[0];
                const img = firstItem.querySelector('img');
                console.log('First photo debug:', {
                    'data-photo-url': firstItem.dataset.photoUrl,
                    'data-processed-url': firstItem.dataset.processedUrl,
                    'img.src': img ? img.src : 'no image'
                });
            }
            
            // Check if storage link exists
            fetch('/storage/.gitignore')
                .then(() => console.log('✅ Storage link appears to be working'))
                .catch(() => {
                    console.error('❌ Storage link may not be set up. Run: php artisan storage:link');
                    // Show alert to user
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-error';
                    alertDiv.innerHTML = '⚠️ Storage link not found! Run: <code>php artisan storage:link</code>';
                    alertDiv.style.marginBottom = '20px';
                    document.querySelector('.photo-page-container').insertBefore(alertDiv, document.querySelector('.photo-page-header'));
                });
        });

        // View photo in lightbox
        function viewPhoto(src, event) {
            if (event) event.stopPropagation();
            
            console.log('Photo URL:', src); // Debug log
            
            // If the URL doesn't start with http, it might be a relative path
            if (!src.startsWith('http') && !src.startsWith('/storage')) {
                console.warn('Unexpected photo URL format:', src);
            }
            
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox';
            
            const img = document.createElement('img');
            img.src = src;
            img.onerror = function() {
                console.error('Failed to load image:', src);
                alert('Unable to load image. Please check if storage link is created (php artisan storage:link)');
            };
            
            const closeBtn = document.createElement('button');
            closeBtn.className = 'lightbox-close';
            closeBtn.textContent = '✕';
            
            lightbox.appendChild(img);
            lightbox.appendChild(closeBtn);
            
            lightbox.addEventListener('click', () => lightbox.remove());
            closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                lightbox.remove();
            });
            
            document.body.appendChild(lightbox);
        }

        // Edit photo
        function editPhoto(photoId, event) {
            if (event) event.stopPropagation();
            
            const modal = document.createElement('div');
            modal.className = 'modal-overlay';
            
            modal.innerHTML = `
                <div class="modal-content">
                    <h3 class="modal-title">Edit Photo</h3>
                    <form method="POST" action="/seller/photos/${photoId}" id="editForm-${photoId}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="form-label">Caption:</label>
                            <input type="text" name="caption" id="edit-caption-${photoId}" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="checkbox-group">
                                <input type="checkbox" name="is_featured" id="edit-featured-${photoId}">
                                <span style="margin-left: 8px;">Set as featured photo</span>
                            </label>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Update</button>
                            <button type="button" class="btn-secondary" onclick="this.closest('.modal-overlay').remove()">Cancel</button>
                        </div>
                    </form>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            // Load current data
            fetch(`/seller/photos/${photoId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`edit-caption-${photoId}`).value = data.photo.caption || '';
                        document.getElementById(`edit-featured-${photoId}`).checked = data.photo.is_featured;
                    }
                });
            
            // Handle form submission
            document.getElementById(`editForm-${photoId}`).addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            });
        }

        // Publish post
        function publishPost() {
            const text = document.getElementById('captionInput').value.trim();
            const featured = document.getElementById('featuredCheck').checked;

            if (selectedFiles.length === 0) {
                alert('Please select photos to upload!');
                return;
            }

            const postBtn = document.querySelector('.post-btn');
            const progressDiv = document.getElementById('uploadProgress');
            
            postBtn.disabled = true;
            progressDiv.style.display = 'block';
            progressDiv.textContent = 'Uploading 0/' + selectedFiles.length + ' photos...';

            let uploadCount = 0;
            const totalPhotos = selectedFiles.length;
            let hasError = false;

            selectedFiles.forEach((photo, index) => {
                const formData = new FormData();
                formData.append('photo', photo.file);
                formData.append('caption', text);
                formData.append('category', 'store');
                formData.append('is_featured', (featured && index === 0) ? '1' : '0');

                fetch('{{ route("seller.photos.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        hasError = true;
                        throw new Error('Upload failed');
                    }
                    // Check if response is JSON
                    const contentType = response.headers.get("content-type");
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        return response.json();
                    } else {
                        // If not JSON (probably a redirect), just return success
                        return { success: true };
                    }
                })
                .then(data => {
                    console.log('Photo uploaded:', data);
                    uploadCount++;
                    progressDiv.textContent = `Uploading ${uploadCount}/${totalPhotos} photos...`;
                    
                    if (uploadCount === totalPhotos) {
                        if (hasError) {
                            progressDiv.textContent = 'Some photos failed to upload. Refreshing...';
                        } else {
                            progressDiv.textContent = 'All photos uploaded successfully! Refreshing...';
                        }
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error('Error uploading photo:', error);
                    uploadCount++;
                    hasError = true;
                    
                    if (uploadCount === totalPhotos) {
                        progressDiv.textContent = 'Some photos failed to upload. Refreshing...';
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                });
            });
        }
    </script>
</div>


@endsection