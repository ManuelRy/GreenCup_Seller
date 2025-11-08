    @extends('master')

    @section('content')
    @php

        // Helper function to limit string length
        function limitString($string, $limit)
        {
            return strlen($string) > $limit ? substr($string, 0, $limit) . '...' : $string;
        }
    @endphp

    <style>
        /* Reset and Base Styles */
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
        }

        html {
        font-size: 16px;
        -webkit-text-size-adjust: 100%;
        }

        body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
        background: #ffffff;
        color: #333333;
        line-height: 1.6;
        min-height: 100vh;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
        }

        /* Container with Teal Theme Background */
        .dashboard-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 50%, #a7f3d0 100%);
        padding-bottom: 60px;
        position: relative;
        z-index: auto;
        }

        /* Header - Simplified */
        .dashboard-header {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(236, 253, 245, 0.95) 100%);
        backdrop-filter: blur(20px);
        padding: 20px;
        position: sticky;
        top: 0;
        z-index: 900;
        box-shadow: 0 4px 20px rgba(0, 176, 155, 0.15);
        border-bottom: 2px solid rgba(0, 176, 155, 0.2);
        }

        .header-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        }

        .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
        position: absolute;
        left: 0;
        }

        .header-back-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(0, 176, 155, 0.1);
        border: none;
        color: #059669;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        }

        .header-back-btn:hover {
        background: rgba(0, 176, 155, 0.2);
        color: #047857;
        text-decoration: none;
        transform: scale(1.1);
        }

        .header-title-section {
        text-align: center;
        }

        .app-title {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        color: #047857;
        letter-spacing: -0.3px;
        }

        /* Main Content */
        .main-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 24px 16px;
        }

        /* Two Column Layout */
        .two-column-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        align-items: start;
        }

        .blurred {
        filter: blur(8px);
        opacity: 0.6;
        }

        .frozen-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.96), rgba(185, 28, 28, 0.96));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 10px 6px;
        text-align: center;
        z-index: 5;
        border-radius: 12px;
        gap: 3px;
        }

        .frozen-overlay-icon {
        font-size: 28px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        .frozen-overlay-title {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        line-height: 1.2;
        }

        .frozen-overlay-text {
        font-size: 8px;
        opacity: 0.95;
        line-height: 1.1;
        font-weight: 600;
        }

        /* Tablet Styles */
        @media (max-width: 1024px) {
        .two-column-layout {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .main-content {
            padding: 20px 16px;
        }
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
        /* Header - BIGGER */
        .dashboard-header {
            padding: 20px;
        }

        .header-back-btn {
            width: 44px;
            height: 44px;
            font-size: 20px;
        }

        .app-title {
            font-size: 22px;
            font-weight: 800;
        }

        /* Main Content */
        .main-content {
            padding: 16px 12px;
        }

        /* Cards - BIGGER padding and closer content */
        .upload-card,
        .gallery-card {
            padding: 24px;
            border-radius: 24px;
            margin-bottom: 20px;
        }

        .gallery-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 176, 155, 0.15);
        }

        /* Make photo thumbnails fill more card space */
        .photo-post-thumbnail {
            margin: 0 -4px 16px -4px;
            border-radius: 20px;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            font-size: 18px;
            border-radius: 12px;
        }

        .user-info h3 {
            font-size: 15px;
        }

        .user-info p {
            font-size: 12px;
        }

        .gallery-title {
            font-size: 18px;
        }

        /* Upload Area - BIGGER */
        .upload-area {
            padding: 40px 20px;
            border-radius: 20px;
        }

        .upload-icon {
            font-size: 56px;
        }

        .upload-text {
            font-size: 18px;
            font-weight: 700;
        }

        .upload-subtext {
            font-size: 15px;
        }

        /* Buttons - BIGGER */
        .upload-btn {
            padding: 16px 28px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
        }

        .action-btn {
            padding: 14px 18px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
        }

        /* Thumbnails - BIGGER containers closer to card edges */
        .post-thumbnail-container {
            padding: 20px;
            gap: 18px;
            margin: -4px;
        }

        .post-thumbnail-image {
            width: 110px;
            height: 110px;
            border-radius: 16px;
        }

        .thumbnail-title {
            font-size: 16px;
            line-height: 1.4;
            font-weight: 600;
        }

        .thumbnail-meta {
            font-size: 13px;
            gap: 4px;
        }

        .thumbnail-actions {
            padding: 16px 20px;
            gap: 12px;
            opacity: 1; /* Always show on mobile */
            margin: 0 -4px -4px -4px; /* Extend closer to card edges */
        }

        .thumbnail-action-btn {
            padding: 12px 16px;
            font-size: 14px;
            border-radius: 10px;
            min-width: 60px;
        }

        /* Modal */
        .post-detail-modal {
            padding: 12px;
        }

        .post-detail-content {
            border-radius: 20px;
            max-height: 95vh;
        }

        .post-detail-header {
            padding: 20px;
            border-radius: 20px 20px 0 0;
        }

        .post-detail-title {
            font-size: 20px;
        }

        .post-detail-close {
            width: 36px;
            height: 36px;
            font-size: 18px;
        }

        .post-detail-body {
            padding: 20px;
        }

        .post-detail-meta {
            padding: 16px;
        }

        .post-detail-images-title,
        .post-detail-caption-title {
            font-size: 16px;
        }

        /* Alert */
        .alert {
            padding: 14px 16px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        /* Location */
        .location-display {
            padding: 16px;
        }

        .location-map {
            width: 70px;
            height: 70px;
        }
        }

        /* Small Mobile Styles */
        @media (max-width: 480px) {
        /* Header - BIGGER for small mobile */
        .dashboard-header {
            padding: 18px;
        }

        .header-back-btn {
            width: 42px;
            height: 42px;
            font-size: 19px;
        }

        .app-title {
            font-size: 20px;
            font-weight: 800;
        }

        /* Cards - BIGGER for small mobile with closer content */
        .upload-card,
        .gallery-card {
            padding: 22px;
            border-radius: 20px;
        }

        /* Make thumbnails closer to card edges on small mobile */
        .photo-post-thumbnail {
            margin: 0 -2px 14px -2px;
        }

        /* Upload Area - BIGGER for small mobile */
        .upload-area {
            padding: 32px 16px;
            border-radius: 18px;
        }

        .upload-icon {
            font-size: 48px;
        }

        .upload-text {
            font-size: 17px;
            font-weight: 700;
        }

        .upload-subtext {
            font-size: 14px;
        }

        /* Thumbnails - BIGGER containers closer to edges for small mobile */
        .post-thumbnail-container {
            padding: 18px;
            gap: 16px;
            margin: -2px;
        }

        .post-thumbnail-image {
            width: 100px;
            height: 100px;
            border-radius: 14px;
        }

        .thumbnail-title {
            font-size: 15px;
            line-height: 1.3;
            font-weight: 600;
        }

        .thumbnail-meta {
            font-size: 12px;
            gap: 3px;
        }

        .thumbnail-actions {
            padding: 14px 18px;
            gap: 10px;
            margin: 0 -2px -2px -2px; /* Closer to card edges */
        }

        .thumbnail-action-btn {
            padding: 10px 14px;
            font-size: 13px;
            border-radius: 8px;
            min-width: 55px;
        }

        /* Modal */
        .post-detail-modal {
            padding: 8px;
        }

        .post-detail-header {
            padding: 16px;
        }

        .post-detail-title {
            font-size: 18px;
        }

        .post-detail-body {
            padding: 16px;
        }

        .post-detail-meta,
        .post-detail-caption-content {
            padding: 12px;
        }

        /* Action buttons - BIGGER for small mobile */
        .action-btn {
            padding: 12px 16px;
            font-size: 14px;
            gap: 6px;
            font-weight: 500;
            border-radius: 8px;
        }

        /* Alert */
        .alert {
            padding: 12px;
            font-size: 12px;
        }

        .alert strong {
            display: block;
            margin-bottom: 4px;
        }

        /* Mobile Photo Thumbnails */
        .photo-post-thumbnail {
            border-radius: 16px;
            margin-bottom: 12px;
        }

        .photo-post-thumbnail:hover {
            transform: translateY(-2px) scale(1.005);
        }

        /* Mobile Badges */
        .thumbnail-featured {
            padding: 3px 6px;
            font-size: 9px;
            top: 4px;
            right: 4px;
        }

        .thumbnail-frozen {
            padding: 3px 5px;
            font-size: 8px;
        }
        }

        /* Upload Card - Teal Theme */
        .upload-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 32px;
        margin-bottom: 0;
        border: 2px solid rgba(0, 176, 155, 0.2);
        height: fit-content;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 32px rgba(0, 176, 155, 0.15);
        }

        .upload-card:hover {
        border-color: rgba(0, 176, 155, 0.4);
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 176, 155, 0.25);
        }

        .upload-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        }

        .user-avatar {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, #00b09b, #00cdac);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
        font-weight: 700;
        box-shadow: 0 4px 16px rgba(0, 176, 155, 0.2);
        }

        .user-info h3 {
        font-size: 17px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 4px;
        letter-spacing: -0.3px;
        }

        .user-info p {
        font-size: 13px;
        color: #059669;
        font-weight: 500;
        }

        .caption-input {
        width: 100%;
        border: none;
        padding: 16px 0;
        font-size: 16px;
        color: #064e3b;
        resize: none;
        min-height: 90px;
        font-family: inherit;
        background: transparent;
        line-height: 1.6;
        }

        .caption-input:focus {
        outline: none;
        }

        .caption-input::placeholder {
        color: #6ee7b7;
        }

        /* Upload Area */
        .upload-section {
        border-top: 1px solid rgba(0, 176, 155, 0.2);
        padding-top: 24px;
        }

        .upload-area {
        border: 3px dashed rgba(0, 176, 155, 0.3);
        border-radius: 20px;
        padding: 48px 24px;
        text-align: center;
        background: linear-gradient(135deg, rgba(240, 253, 250, 0.5) 0%, rgba(204, 251, 241, 0.5) 100%);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 24px;
        }

        .upload-area:hover {
        border-color: #00b09b;
        background: linear-gradient(135deg, rgba(204, 251, 241, 0.8) 0%, rgba(167, 243, 208, 0.8) 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 176, 155, 0.2);
        }

        .upload-area.dragover {
        border-color: #00b09b;
        background: linear-gradient(135deg, #ccfbf1 0%, #99f6e4 100%);
        box-shadow: 0 12px 32px rgba(0, 176, 155, 0.2);
        }

        .upload-icon {
        font-size: 56px;
        margin-bottom: 20px;
        opacity: 0.85;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .upload-text {
        font-size: 19px;
        color: #0d9488;
        margin-bottom: 10px;
        font-weight: 700;
        letter-spacing: -0.3px;
        }

        .upload-subtext {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
        }

        .file-input {
        display: none;
        }

        /* Photo Preview Grid */
        .photo-preview-grid {
        display: none;
        gap: 12px;
        border-radius: 16px;
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
        height: 300px;
        }

        .photo-preview-grid.three {
        display: grid;
        grid-template-columns: 2fr 1fr;
        grid-template-rows: 1fr 1fr;
        height: 350px;
        }

        .photo-preview-grid.four-plus {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        height: 350px;
        }

        .photo-item {
        position: relative;
        background: #f0f0f0;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 1;
        cursor: pointer;
        }

        .photo-item.large {
        grid-row: span 2;
        aspect-ratio: auto;
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

        .photo-overlay {
        position: absolute;
        top: 8px;
        right: 8px;
        display: flex;
        gap: 4px;
        opacity: 0;
        transition: opacity 0.2s ease;
        }

        .photo-item:hover .photo-overlay {
        opacity: 1;
        }

        .overlay-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.7);
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
        background: rgba(0, 0, 0, 0.9);
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

        /* Location Display */
        .location-display {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #93c5fd;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 24px;
        position: relative;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
        }

        .location-info {
        display: flex;
        gap: 16px;
        align-items: center;
        }

        .location-text {
        flex: 1;
        }

        .location-title {
        font-size: 14px;
        font-weight: 700;
        color: #1e40af;
        margin-bottom: 6px;
        }

        .location-address {
        font-size: 15px;
        color: #1e3a8a;
        margin-bottom: 4px;
        font-weight: 600;
        }

        .location-coords {
        font-size: 12px;
        color: #3b82f6;
        font-family: 'Courier New', monospace;
        font-weight: 500;
        }

        .location-map {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
        border: 2px solid #60a5fa;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
        }

        .location-map:hover {
        transform: scale(1.08);
        border-color: #3b82f6;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.25);
        }

        .map-overlay {
        position: absolute;
        bottom: 4px;
        right: 4px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        }

        .remove-location-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #dc2626;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 4px rgba(220, 38, 38, 0.15);
        }

        .remove-location-btn:hover {
        background: #fecaca;
        border-color: #fca5a5;
        transform: scale(1.1) rotate(90deg);
        box-shadow: 0 4px 8px rgba(220, 38, 38, 0.25);
        }

        /* Action Buttons */
        .upload-actions {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        }

        .action-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 16px;
        border: 2px solid rgba(0, 176, 155, 0.2);
        background: rgba(255, 255, 255, 0.8);
        color: #059669;
        font-size: 14px;
        font-weight: 600;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 176, 155, 0.1);
        }

        .action-btn:hover {
        background: rgba(240, 253, 250, 0.95);
        color: #047857;
        border-color: rgba(0, 176, 155, 0.4);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 176, 155, 0.2);
        }

        .action-btn.active {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border: 2px solid #6ee7b7;
        box-shadow: 0 4px 16px rgba(0, 176, 155, 0.25);
        }

        /* Options Panel */
        .options-panel {
        background: linear-gradient(135deg, rgba(240, 253, 250, 0.8) 0%, rgba(209, 250, 229, 0.8) 100%);
        padding: 20px;
        border-radius: 14px;
        margin-bottom: 24px;
        display: none;
        border: 2px solid rgba(0, 176, 155, 0.2);
        box-shadow: 0 2px 8px rgba(0, 176, 155, 0.1);
        }

        .options-panel.active {
        display: block;
        animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
        }

        .checkbox-group {
        display: flex;
        align-items: center;
        gap: 8px;
        }

        .checkbox-group input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: #00b09b;
        cursor: pointer;
        }

        .checkbox-group label {
        color: #065f46;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        }

        /* Upload Button */
        .upload-btn {
        background: linear-gradient(135deg, #00b09b, #00cdac);
        color: white;
        padding: 18px 36px;
        border: none;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
        box-shadow: 0 6px 20px rgba(0, 176, 155, 0.25), 0 2px 4px rgba(0, 0, 0, 0.05);
        letter-spacing: 0.3px;
        }

        .upload-btn:hover {
        background: linear-gradient(135deg, #009688, #00b09b);
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(0, 176, 155, 0.35), 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .upload-btn:disabled {
        background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
        color: #94a3b8;
        cursor: not-allowed;
        transform: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        /* Progress Indicator */
        .upload-progress {
        text-align: center;
        color: #00b09b;
        font-weight: 600;
        margin-top: 16px;
        display: none;
        }

        /* Photo Posts Thumbnails */
        .photo-posts-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        }

        @media (min-width: 1200px) {
        .photo-posts-container {
            grid-template-columns: 1fr;
        }
        }

        .photo-post-thumbnail {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(240, 253, 244, 0.95) 100%);
        border: none;
        border-radius: 20px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        box-shadow: 0 6px 20px rgba(0, 176, 155, 0.12), 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .photo-post-thumbnail:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow: 0 12px 32px rgba(0, 176, 155, 0.25), 0 6px 12px rgba(0, 0, 0, 0.08);
        }

        .photo-post-thumbnail::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, transparent 0%, rgba(0, 176, 155, 0.03) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
        }

        .photo-post-thumbnail:hover::before {
        opacity: 1;
        }

        .post-thumbnail-container {
        display: flex;
        gap: 16px;
        padding: 16px;
        align-items: center;
        }

        .post-thumbnail-image {
        width: 90px;
        height: 90px;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        flex-shrink: 0;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 176, 155, 0.2);
        }

        .post-thumbnail-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
        }

        .photo-post-thumbnail:hover .post-thumbnail-image img {
        transform: scale(1.1);
        }

        .post-thumbnail-image::before {
        content: "📷";
        font-size: 20px;
        opacity: 0.3;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 0;
        }

        .thumbnail-count {
        position: absolute;
        top: 4px;
        right: 4px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 2px 6px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 600;
        }

        .thumbnail-featured {
        position: absolute;
        top: 6px;
        right: 6px;
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: white;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
        box-shadow: 0 3px 10px rgba(251, 191, 36, 0.5);
        display: flex;
        align-items: center;
        gap: 3px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 6;
        border: 1.5px solid rgba(255, 255, 255, 0.3);
        }

        .thumbnail-featured::before {
        content: '⭐';
        font-size: 12px;
        }

        .thumbnail-frozen {
        position: absolute;
        top: 4px;
        left: 4px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        padding: 4px 6px;
        border-radius: 6px;
        font-size: 9px;
        font-weight: 700;
        z-index: 10;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
        animation: pulse-warning 2s infinite;
        }

        @keyframes pulse-warning {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
            transform: scale(1.05);
        }
        }

        .post-thumbnail-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
        }

        .thumbnail-title {
        font-size: 16px;
        font-weight: 700;
        color: #047857;
        margin-bottom: 0;
        line-height: 1.4;
        word-wrap: break-word;
        letter-spacing: -0.3px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        }

        .thumbnail-meta {
        font-size: 12px;
        color: #059669;
        line-height: 1.6;
        font-weight: 500;
        display: flex;
        flex-direction: column;
        gap: 4px;
        }

        .thumbnail-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        }

        .thumbnail-meta-icon {
        font-size: 14px;
        opacity: 0.7;
        }

        .thumbnail-actions {
        display: flex;
        gap: 8px;
        padding: 12px 16px;
        border-top: 1px solid rgba(0, 176, 155, 0.1);
        background: linear-gradient(135deg, rgba(240, 253, 244, 0.6) 0%, rgba(209, 250, 229, 0.4) 100%);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .photo-post-thumbnail:hover .thumbnail-actions {
        opacity: 1;
        }

        .thumbnail-action-btn {
        flex: 1;
        padding: 10px 16px;
        border: 1.5px solid rgba(0, 176, 155, 0.2);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.9);
        color: #059669;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(0, 176, 155, 0.08);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        }

        .thumbnail-action-btn:hover {
        background: #ffffff;
        color: #047857;
        border-color: rgba(0, 176, 155, 0.4);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 176, 155, 0.15);
        }

        .thumbnail-action-btn.delete-btn {
        border-color: rgba(220, 38, 38, 0.2);
        color: #dc2626;
        }

        .thumbnail-action-btn.delete-btn:hover {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        color: #b91c1c;
        border-color: rgba(220, 38, 38, 0.4);
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.15);
        }

        /* Post Detail Modal */
        .post-detail-modal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        background: rgba(6, 78, 59, 0.8);
        backdrop-filter: blur(12px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999999 !important;
        padding: 20px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .post-detail-modal.active {
        opacity: 1;
        visibility: visible;
        }

        .post-detail-content {
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
        border-radius: 24px;
        max-width: 800px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 24px 60px rgba(0, 176, 155, 0.3), 0 8px 16px rgba(0, 0, 0, 0.15);
        border: 2px solid rgba(0, 176, 155, 0.3);
        transform: scale(0.92) translateY(20px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        z-index: 99999999 !important;
        }

        .post-detail-modal.active .post-detail-content {
        transform: scale(1) translateY(0);
        }

        .post-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 28px 36px;
        border-bottom: 2px solid rgba(0, 176, 155, 0.2);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 253, 244, 0.95) 100%);
        border-radius: 24px 24px 0 0;
        }

        .post-detail-title {
        font-size: 26px;
        font-weight: 700;
        color: #047857;
        letter-spacing: -0.5px;
        }

        .post-detail-close {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(167, 243, 208, 0.3);
        border: 2px solid rgba(0, 176, 155, 0.3);
        color: #059669;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        }

        .post-detail-close:hover {
        background: rgba(167, 243, 208, 0.5);
        border-color: rgba(0, 176, 155, 0.5);
        color: #047857;
        transform: rotate(90deg);
        }

        .post-detail-body {
        padding: 36px;
        }

        .post-detail-meta {
        background: linear-gradient(135deg, rgba(240, 253, 250, 0.6) 0%, rgba(209, 250, 229, 0.6) 100%);
        padding: 20px;
        border-radius: 16px;
        margin-bottom: 28px;
        border: 2px solid rgba(0, 176, 155, 0.15);
        }

        .post-detail-meta-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid rgba(0, 176, 155, 0.15);
        }

        .post-detail-meta-item:last-child {
        border-bottom: none;
        }

        .post-detail-meta-label {
        font-size: 14px;
        font-weight: 700;
        color: #059669;
        }

        .post-detail-meta-value {
        font-size: 14px;
        font-weight: 600;
        color: #065f46;
        }

        .post-detail-images {
        margin-bottom: 24px;
        }

        .post-detail-images-title {
        font-size: 19px;
        font-weight: 700;
        color: #047857;
        margin-bottom: 20px;
        letter-spacing: -0.3px;
        }

        .post-detail-image-grid {
        display: grid;
        gap: 12px;
        border-radius: 16px;
        overflow: hidden;
        }

        .post-detail-image-grid.single {
        grid-template-columns: 1fr;
        }

        .post-detail-image-grid.two {
        grid-template-columns: 1fr 1fr;
        }

        .post-detail-image-grid.three {
        grid-template-columns: 2fr 1fr;
        grid-template-rows: 1fr 1fr;
        }

        .post-detail-image-grid.four-plus {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        }

        .post-detail-image-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        background: #f0f0f0;
        }

        .post-detail-image-item.large {
        grid-row: 1 / 3;
        }

        .post-detail-image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
        }

        .post-detail-image-item:hover img {
        transform: scale(1.05);
        }

        .modal-frozen-banner {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        padding: 16px 20px;
        border-radius: 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: start;
        gap: 12px;
        box-shadow: 0 4px 16px rgba(220, 38, 38, 0.3);
        border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .modal-frozen-icon {
        font-size: 28px;
        flex-shrink: 0;
        }

        .modal-frozen-content {
        flex: 1;
        }

        .modal-frozen-title {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        }

        .modal-frozen-text {
        font-size: 13px;
        opacity: 0.95;
        line-height: 1.5;
        }

        .post-detail-more-images {
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

        .post-detail-caption {
        margin-top: 24px;
        }

        .post-detail-caption-title {
        font-size: 17px;
        font-weight: 700;
        color: #047857;
        margin-bottom: 14px;
        letter-spacing: -0.3px;
        }

        .post-detail-caption-content {
        font-size: 15px;
        color: #065f46;
        line-height: 1.7;
        padding: 20px;
        background: linear-gradient(135deg, rgba(240, 253, 250, 0.6) 0%, rgba(209, 250, 229, 0.6) 100%);
        border-radius: 14px;
        border: 2px solid rgba(0, 176, 155, 0.15);
        }

        /* Gallery Section - Teal Theme */
        .gallery-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 32px;
        height: fit-content;
        border: 2px solid rgba(0, 176, 155, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 32px rgba(0, 176, 155, 0.15);
        }

        .gallery-card:hover {
        border-color: rgba(0, 176, 155, 0.4);
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 176, 155, 0.25);
        }

        .gallery-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        }

        .gallery-title {
        font-size: 20px;
        font-weight: 700;
        color: #047857;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.3px;
        }

        .gallery-count {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        }

        .photo-posts-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
        }

        .photo-post {
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        overflow: hidden;
        background: white;
        transition: box-shadow 0.3s ease;
        }

        .photo-post:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .photo-post-grid {
        display: grid;
        gap: 2px;
        }

        .photo-post-grid.single {
        grid-template-columns: 1fr;
        }

        .photo-post-grid.single .gallery-photo-item {
        aspect-ratio: 4/3;
        max-height: 500px;
        }

        .photo-post-grid.two {
        grid-template-columns: 1fr 1fr;
        height: 300px;
        }

        .photo-post-grid.three {
        grid-template-columns: 2fr 1fr;
        grid-template-rows: 1fr 1fr;
        height: 350px;
        }

        .photo-post-grid.four-plus {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        height: 350px;
        }

        .gallery-photo-item {
        position: relative;
        overflow: hidden;
        cursor: pointer;
        background: #f0f0f0;
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
        }

        .gallery-photo-item:hover img {
        transform: scale(1.02);
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

        .gallery-photo-overlay {
        position: absolute;
        top: 8px;
        right: 8px;
        display: flex;
        gap: 4px;
        opacity: 0;
        transition: opacity 0.2s ease;
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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .photo-post-info {
        padding: 16px 20px;
        background: #f9f9f9;
        border-top: 1px solid #f0f0f0;
        }

        .post-meta {
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
        }

        .post-caption {
        font-size: 14px;
        color: #333;
        line-height: 1.4;
        }

        /* Empty State */
        .empty-state {
        text-align: center;
        padding: 60px 24px;
        }

        .empty-icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
        }

        .empty-title {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin-bottom: 12px;
        }

        .empty-text {
        font-size: 16px;
        color: #666;
        margin-bottom: 32px;
        line-height: 1.5;
        }

        /* Alert Messages - Professional Design */
        .alert {
        padding: 18px 24px;
        border-radius: 16px;
        margin-bottom: 24px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        font-size: 14px;
        line-height: 1.6;
        }

        .alert-success {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        color: #15803d;
        border: 1px solid #86efac;
        }

        .alert-error {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        color: #dc2626;
        border: 1px solid #fecaca;
        }

        /* Modal Styles */
        .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
        }

        .modal-content {
        background: white;
        padding: 32px;
        border-radius: 20px;
        max-width: 500px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .modal-title {
        margin-bottom: 24px;
        color: #333;
        font-size: 24px;
        font-weight: 600;
        }

        .form-group {
        margin-bottom: 20px;
        }

        .form-label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 600;
        }

        .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #f0f0f0;
        border-radius: 12px;
        font-size: 16px;
        transition: border-color 0.2s ease;
        }

        .form-input:focus {
        outline: none;
        border-color: #00b09b;
        }

        .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        }

        .btn-primary {
        flex: 1;
        background: linear-gradient(135deg, #00b09b, #00cdac);
        color: white;
        padding: 14px 24px;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 176, 155, 0.3);
        }

        .btn-primary:hover {
        background: linear-gradient(135deg, #009688, #00b09b);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 176, 155, 0.4);
        }

        .btn-secondary {
        flex: 1;
        background: #f8f9fa;
        color: #666;
        padding: 14px 24px;
        border: 2px solid #f0f0f0;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        }

        .btn-secondary:hover {
        background: #e9ecef;
        color: #333;
        }

        /* Lightbox */
        .lightbox {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999999999 !important;
        cursor: pointer;
        padding: 20px;
        }

        .lightbox img {
        max-width: 95%;
        max-height: 95%;
        object-fit: contain;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        }

        .lightbox-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        font-size: 24px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        z-index: 999999999 !important;
        }

        .lightbox-close:hover {
        background: rgba(0, 0, 0, 0.9);
        transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
        .main-content {
            padding: 16px 12px;
        }

        .upload-actions {
            flex-direction: column;
        }

        .location-info {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }

        .location-map {
            width: 100%;
            max-width: 120px;
            height: 120px;
            margin: 0 auto;
        }

        .photo-preview-grid.three,
        .photo-preview-grid.four-plus,
        .post-detail-image-grid.three,
        .post-detail-image-grid.four-plus {
            grid-template-columns: 1fr 1fr;
            height: 250px;
        }

        .photo-preview-grid.single {
            max-height: 300px;
        }

        .modal-content,
        .post-detail-content {
            padding: 24px;
            margin: 20px;
        }

        .photo-posts-container {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .post-thumbnail-container {
            gap: 10px;
            padding: 10px;
        }

        .post-thumbnail-image {
            width: 50px;
            height: 50px;
        }

        .thumbnail-actions {
            opacity: 1;
            justify-content: center;
            padding: 6px 10px;
        }

        .thumbnail-action-btn {
            padding: 4px 8px;
            font-size: 10px;
        }

        .gallery-header {
            flex-direction: column;
            gap: 12px;
            text-align: center;
            align-items: center;
        }

        .gallery-header-actions {
            flex-direction: column;
            gap: 8px;
        }

        .gallery-action-btn {
            padding: 8px 16px;
            font-size: 13px;
        }

        .header-content {
            flex-direction: column;
            gap: 16px;
            text-align: center;
        }

        .header-left {
            justify-content: center;
        }

        .app-title {
            font-size: 20px;
        }

        .app-subtitle {
            font-size: 13px;
        }
        }

        @media (max-width: 480px) {
        .upload-area {
            padding: 30px 15px;
        }

        .upload-icon {
            font-size: 36px;
        }

        .upload-text {
            font-size: 16px;
        }

        .location-display {
            padding: 12px;
        }

        .location-text {
            font-size: 14px;
        }

        .photo-preview-grid.two,
        .post-detail-image-grid.two {
            height: 200px;
        }

        .post-thumbnail-image {
            width: 45px;
            height: 45px;
        }

        .thumbnail-title {
            font-size: 13px;
        }

        .thumbnail-meta {
            font-size: 10px;
        }

        .post-detail-content {
            margin: 10px;
            max-height: 95vh;
        }

        .post-detail-title {
            font-size: 20px;
        }

        .gallery-title {
            font-size: 18px;
        }

        .gallery-action-btn {
            padding: 6px 12px;
            font-size: 12px;
        }

        .gallery-count {
            font-size: 12px;
        }

        .app-title {
            font-size: 18px;
        }

        .app-subtitle {
            font-size: 12px;
        }

        .back-button {
            padding: 10px 16px;
            font-size: 13px;
        }

        .header-back-btn {
            width: 36px;
            height: 36px;
            font-size: 16px;
        }
        }

        /* Utility Classes */
        .text-center {
        text-align: center;
        }

        .fade-in {
        animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
        }
    </style>

    <div class="dashboard-container">
        <!-- Header -->
        <header class="dashboard-header">
        <div class="header-content">
            <div class="header-left">
            <a href="{{ route('dashboard') }}" class="header-back-btn">
                ←
            </a>
            </div>
            <div class="header-title-section">
                <h1 class="app-title">📸 Store Gallery Manager</h1>
            </div>
        </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
        <!-- Alerts - SINGLE INSTANCE ONLY -->
        @if (session('success'))
            <div class="alert alert-success fade-in">
            ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error fade-in">
            ❌ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error fade-in">
            @foreach ($errors->all() as $error)
                ❌ {{ $error }}<br>
            @endforeach
            </div>
        @endif

        @php
            $frozenCount = $photos->filter(function($p) {
                return $p->isFrozen();
            })->count();
        @endphp

        @if ($frozenCount > 0)
            <div class="alert alert-error fade-in" style="max-width: 1200px; margin: 0 auto 24px auto;">
                <div style="display: flex; align-items: start; gap: 12px;">
                    <span style="font-size: 24px; flex-shrink: 0;">⚠️</span>
                    <div style="flex: 1;">
                        <strong>{{ $frozenCount }} photo{{ $frozenCount > 1 ? 's have' : ' has' }} been frozen by admin</strong>
                        <div style="margin-top: 4px; font-size: 13px; opacity: 0.95;">These images are hidden from customers due to policy violations. Please review and remove inappropriate content.</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Two Column Layout -->
        <div class="two-column-layout">
            <!-- Upload Card -->
            <div class="upload-card fade-in">
            <div class="upload-header">
                <div class="user-avatar">
                {{ substr($seller->business_name, 0, 1) }}
                </div>
                <div class="user-info">
                <h3>{{ $seller->business_name }}</h3>
                <p>📍 Phnom Penh, Cambodia</p>
                </div>
            </div>

            <textarea class="caption-input" placeholder="What's new in your store today? Share photos and tell customers about your latest products or updates..." id="captionInput"></textarea>

            <div class="upload-section">
                <!-- Upload Area -->
                <div class="upload-area" onclick="document.getElementById('photoInput').click()" id="dropArea">
                <div class="upload-icon">📸</div>
                <div class="upload-text">Add photos to your post</div>
                <div class="upload-subtext">Click to select photos or drag and drop (Max 5MB each)</div>
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

                <!-- Location Display -->
                <div id="locationDisplay" class="location-display" style="display: none;">
                <div class="location-info">
                    <div class="location-text">
                    <div class="location-title">📍 Current Location</div>
                    <div class="location-address" id="locationAddress">Getting location...</div>
                    <div class="location-coords" id="locationCoords"></div>
                    </div>
                    <div class="location-map" id="locationMap" onclick="openDetailedMap()">
                    <img id="mapThumbnail" src="" alt="Map thumbnail" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                    <div class="map-overlay">🔍</div>
                    </div>
                </div>
                <button class="remove-location-btn" onclick="removeLocation()">❌</button>
                </div>

                <!-- Action Buttons -->
                <div class="upload-actions">
                <button class="action-btn" id="photoBtn" onclick="togglePhotoOptions()">
                    📷 Photo Options
                </button>
                <button class="action-btn" id="locationBtn" onclick="getCurrentLocation()">
                    📍 Use Current Location
                </button>
                </div>

                <button class="upload-btn" onclick="publishPost()" disabled id="uploadBtn">
                Share Photos
                </button>
                <div id="uploadProgress" class="upload-progress"></div>
            </div>
            </div>

            <!-- Photo Gallery -->
            @if ($photos->count() > 0)
            <div class="gallery-card fade-in">
                <div class="gallery-header">
                <h2 class="gallery-title">
                    📸 Your Photo Gallery
                    @if($photos->count() > 0)
                        <span class="gallery-count">{{ $photos->count() }}</span>
                    @endif
                </h2>
                <div class="gallery-header-actions">
                    <button class="gallery-action-btn" onclick="scrollToUpload()">
                    ➕ Add Photos
                    </button>
                </div>
                </div>

                <div class="photo-posts-container">
                @php
                    // Group photos by upload session (photos uploaded within 10 seconds of each other)
                    // $groupedPhotos = collect();
                    $processedIds = collect();

                    foreach ($photos as $photo) {
                        if ($processedIds->contains($photo->id)) {
                            continue;
                        }

                        // Find all photos uploaded within 10 seconds of this photo
                        $sessionPhotos = $photos->filter(function ($p) use ($photo, $processedIds) {
                            return !$processedIds->contains($p->id) && abs($photo->created_at->diffInSeconds($p->created_at)) <= 10;
                        });

                        // $groupedPhotos->push($sessionPhotos);
                        $processedIds = $processedIds->merge($sessionPhotos->pluck('id'));
                    }
                @endphp

                @foreach ($photos as $index => $photo)
                    @php
                    $isFrozen = $photo->isFrozen();
                    @endphp
                    <div class="photo-post-thumbnail" onclick="showPostDetails({{ $photo->id }})">
                    <div class="post-thumbnail-container">
                        <div class="post-thumbnail-image" style="position: relative;">
                        <img src="{{ $photo->photo_url }}" alt="{{ $photo->trimCaption() ?: 'Store photo' }}" class="{{ $isFrozen ? 'blurred' : '' }}"
                            onerror="this.style.display='none'; this.parentElement.classList.add('img-error');">

                        @if ($isFrozen)
                            <div class="frozen-overlay">
                                <div class="frozen-overlay-icon">⚠️</div>
                                <div class="frozen-overlay-title">Hidden by Admin</div>
                                <div class="frozen-overlay-text">Policy violation</div>
                            </div>
                        @endif

                        @if ($photo->is_featured && !$isFrozen)
                            <div class="thumbnail-featured">Featured</div>
                        @endif
                        </div>
                        <div class="post-thumbnail-info">
                        <div class="thumbnail-title">
                            @if ($photo->trimCaption())
                            {{ limitString($photo->trimCaption(), 50) }}
                            @else
                            <span style="color: #6ee7b7; font-style: italic; font-weight: 500;">Store Photos</span>
                            @endif
                        </div>
                        <div class="thumbnail-meta">
                            <div class="thumbnail-meta-item">
                                <span class="thumbnail-meta-icon">📅</span>
                                <span>{{ $photo->created_at->format('M j, Y') }}</span>
                            </div>
                            @if ($photo->is_featured && !$isFrozen)
                            <div class="thumbnail-meta-item">
                                <span class="thumbnail-meta-icon">⭐</span>
                                <span>Featured</span>
                            </div>
                            @endif
                        </div>
                        </div>
                    </div>
                    <div class="thumbnail-actions">
                        <button class="thumbnail-action-btn" onclick="showPostDetails({{ $photo->id }}, event)" title="View Details">
                            <span>👁️</span>
                            <span>View</span>
                        </button>
                        <form action="{{ route('seller.photos.destroy', $photo->id) }}" method="POST" style="display: inline; flex: 1;"
                        onsubmit="return confirm('Are you sure you want to delete this photo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="thumbnail-action-btn delete-btn" onclick="event.stopPropagation();" title="Delete" style="width: 100%;">
                            <span>🗑️</span>
                            <span>Delete</span>
                        </button>
                        </form>
                    </div>
                    </div>
                @endforeach
                </div>
            </div>
            @else
            <div class="gallery-card fade-in">
                <div class="empty-state">
                <div class="empty-icon">📷</div>
                <h3 class="empty-title">No photos yet</h3>
                <p class="empty-text">Upload your first photo to start building your store gallery and attract more customers!</p>
                </div>
            </div>
            @endif
        </div>
        </main>
    </div>

    <!-- Post Detail Modal -->
    <div id="post-detail-modal" class="post-detail-modal" onclick="closePostDetailModal(event)">
        <div class="post-detail-content" onclick="event.stopPropagation()">
        <div class="post-detail-header">
            <h3 class="post-detail-title" id="post-detail-title">Post Details</h3>
            <button class="post-detail-close" onclick="closePostDetailModal()">✕</button>
        </div>

        <div class="post-detail-body">
            <div id="modal-frozen-banner" style="display: none;">
                <div class="modal-frozen-banner">
                    <div class="modal-frozen-icon">⚠️</div>
                    <div class="modal-frozen-content">
                        <div class="modal-frozen-title">Content Hidden by Admin</div>
                        <div class="modal-frozen-text">This photo has been frozen due to policy violations and is not visible to customers. Please review our content guidelines and consider removing this image.</div>
                    </div>
                </div>
            </div>

            <div class="post-detail-meta" id="post-detail-meta">
            <!-- Meta information will be populated here -->
            </div>

            <div class="post-detail-images" id="post-detail-images">
            <h4 class="post-detail-images-title">Photos</h4>
            <div class="post-detail-image-grid" id="post-detail-image-grid">
                <!-- Images will be populated here -->
            </div>
            </div>

            <div class="post-detail-caption" id="post-detail-caption" style="display: none;">
            <h4 class="post-detail-caption-title">Caption</h4>
            <div class="post-detail-caption-content" id="post-detail-caption-content">
                <!-- Caption will be populated here -->
            </div>
            </div>
        </div>
        </div>
    </div>

    <script>
        /*
        * Photo Gallery with Location Features & Thumbnail Details
        *
        * For better geocoding (address lookup), consider:
        * 1. OpenCage Geocoding API (free tier available)
        * 2. Google Geocoding API (requires API key)
        * 3. Mapbox Geocoding API (generous free tier)
        *
        * Current implementation uses fallback address detection for Cambodia locations
        */

        // Move modal to body root to escape stacking context
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('post-detail-modal');
            if (modal) {
                document.body.appendChild(modal);
            }
        });

        let selectedFiles = [];
        let photoCounter = 0;
        let currentLocation = null;

        // Photo groups data for modal display
        const photoGroupsData = [
        @foreach ($photos as $p)
            {
            id: {{ $p->id }},
            url: "{{ $p->photo_url }}",
            caption: "{{ $p->photo_caption ?: '' }}",
            is_featured: {{ $p->is_featured ? 'true' : 'false' }},
            created_at: "{{ $p->created_at->format('M j, Y g:i A') }}",
            category: "{{ $p->category ?: 'store' }}",
            latitude: "{{ $p->latitude ?? '' }}",
            longitude: "{{ $p->longitude ?? '' }}",
            location_address: "{{ $p->location_address ?? '' }}"
            }
            @if (!$loop->last)
            ,
            @endif
        @endforeach
        ];

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
            // Check file size (5MB limit)
            if (file.size > 5 * 1024 * 1024) {
                alert(`${file.name} is too large. Please select images under 5MB.`);
                return;
            }

            selectedFiles.push({
                file: file,
                id: ++photoCounter,
                url: URL.createObjectURL(file)
            });
            }
        });

        updatePhotoGrid();
        updateUploadButton();
        }

        // Drag and drop functionality
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
        updateUploadButton();

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

        // Get current location
        function getCurrentLocation() {
        const locationBtn = document.getElementById('locationBtn');
        locationBtn.disabled = true;
        locationBtn.textContent = '📍 Getting Location...';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
            function(position) {
                currentLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
                };

                // Show location display
                showLocationDisplay();

                // Update button
                locationBtn.disabled = false;
                locationBtn.textContent = '📍 Location Added ✓';
                locationBtn.classList.add('active');

                // Get address and map thumbnail
                getAddressFromCoords(currentLocation.lat, currentLocation.lng);
                generateMapThumbnail(currentLocation.lat, currentLocation.lng);
            },
            function(error) {
                console.error('Error getting location:', error);

                // Use default location (Phnom Penh)
                currentLocation = {
                lat: 11.5564,
                lng: 104.9282
                };

                // Show location display with default
                showLocationDisplay();

                // Update button
                locationBtn.disabled = false;
                locationBtn.textContent = '📍 Default Location Used';
                locationBtn.classList.add('active');

                // Set default address and map
                document.getElementById('locationAddress').textContent = 'Phnom Penh, Cambodia (Default)';
                generateMapThumbnail(currentLocation.lat, currentLocation.lng);

                alert('❌ Unable to get your location. Using default location: Phnom Penh, Cambodia');
            }
            );
        } else {
            // Geolocation not supported - use default
            currentLocation = {
            lat: 11.5564,
            lng: 104.9282
            };
            showLocationDisplay();

            locationBtn.disabled = false;
            locationBtn.textContent = '📍 Default Location';
            locationBtn.classList.add('active');

            document.getElementById('locationAddress').textContent = 'Phnom Penh, Cambodia (Default)';
            generateMapThumbnail(currentLocation.lat, currentLocation.lng);

            alert('❌ Geolocation is not supported by this browser. Using default location.');
        }
        }

        // Show location display
        function showLocationDisplay() {
        const display = document.getElementById('locationDisplay');
        display.style.display = 'block';

        // Update coordinates
        document.getElementById('locationCoords').textContent =
            `${currentLocation.lat.toFixed(6)}, ${currentLocation.lng.toFixed(6)}`;
        }

        // Remove location
        function removeLocation() {
        currentLocation = null;
        document.getElementById('locationDisplay').style.display = 'none';

        const locationBtn = document.getElementById('locationBtn');
        locationBtn.textContent = '📍 Use Current Location';
        locationBtn.classList.remove('active');
        }

        // Get address from coordinates (reverse geocoding)
        function getAddressFromCoords(lat, lng) {
        // Using a simple approach - you can replace with a proper geocoding service
        fetch(`https://api.opencagedata.com/geocode/v1/json?q=${lat}+${lng}&key=YOUR_API_KEY`)
            .then(response => response.json())
            .then(data => {
            if (data.results && data.results[0]) {
                const address = data.results[0].formatted;
                document.getElementById('locationAddress').textContent = address;
            } else {
                // Fallback to simple coordinates display
                document.getElementById('locationAddress').textContent =
                `Latitude: ${lat.toFixed(4)}, Longitude: ${lng.toFixed(4)}`;
            }
            })
            .catch(error => {
            console.error('Geocoding error:', error);
            // Fallback for common locations in Cambodia
            if (lat > 11.5 && lat < 11.6 && lng > 104.9 && lng < 105.0) {
                document.getElementById('locationAddress').textContent = 'Phnom Penh, Cambodia';
            } else if (lat > 13.3 && lat < 13.4 && lng > 103.8 && lng < 103.9) {
                document.getElementById('locationAddress').textContent = 'Siem Reap, Cambodia';
            } else {
                document.getElementById('locationAddress').textContent =
                `Location: ${lat.toFixed(4)}, ${lng.toFixed(4)}`;
            }
            });
        }

        // Generate map thumbnail
        function generateMapThumbnail(lat, lng) {
        const mapImg = document.getElementById('mapThumbnail');

        // Using OpenStreetMap static map (free alternative to Google Maps)
        const mapUrl =
            `https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/pin-s-l+000(${lng},${lat})/${lng},${lat},14/160x160?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw`;

        // Fallback to a simple colored map placeholder
        mapImg.onerror = function() {
            const canvas = document.createElement('canvas');
            canvas.width = 160;
            canvas.height = 160;
            const ctx = canvas.getContext('2d');

            // Draw a simple map-like background
            const gradient = ctx.createLinearGradient(0, 0, 160, 160);
            gradient.addColorStop(0, '#e6f3ff');
            gradient.addColorStop(1, '#b3d9ff');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, 160, 160);

            // Draw grid lines to look like a map
            ctx.strokeStyle = '#99ccff';
            ctx.lineWidth = 1;
            for (let i = 0; i < 160; i += 20) {
            ctx.beginPath();
            ctx.moveTo(i, 0);
            ctx.lineTo(i, 160);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(0, i);
            ctx.lineTo(160, i);
            ctx.stroke();
            }

            // Draw a pin in the center
            ctx.fillStyle = '#ff4444';
            ctx.beginPath();
            ctx.arc(80, 70, 8, 0, 2 * Math.PI);
            ctx.fill();
            ctx.fillRect(76, 70, 8, 20);

            // Convert to data URL and set as image source
            mapImg.src = canvas.toDataURL();
        };

        mapImg.src = mapUrl;
        }

        // Open detailed map
        function openDetailedMap() {
        if (!currentLocation) return;

        const googleMapsUrl = `https://www.google.com/maps?q=${currentLocation.lat},${currentLocation.lng}&z=15&t=m`;
        window.open(googleMapsUrl, '_blank');
        }

        // Update upload button
        function updateUploadButton() {
        const uploadBtn = document.getElementById('uploadBtn');
        const hasPhotos = selectedFiles.length > 0;
        const hasText = document.getElementById('captionInput').value.trim().length > 0;

        uploadBtn.disabled = !(hasPhotos || hasText);

        if (hasPhotos) {
            uploadBtn.textContent = `Share ${selectedFiles.length} Photo${selectedFiles.length > 1 ? 's' : ''}`;
        } else {
            uploadBtn.textContent = 'Share Photos';
        }
        }

        document.getElementById('captionInput').addEventListener('input', updateUploadButton);

        // View photo in lightbox
        function viewPhoto(src, event) {
        if (event) event.stopPropagation();

        const lightbox = document.createElement('div');
        lightbox.className = 'lightbox';

        const img = document.createElement('img');
        img.src = src;
        img.onerror = function() {
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
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label class="form-label">Caption:</label>
                        <input type="text" name="caption" id="edit-caption-${photoId}" class="form-input" placeholder="Add a caption for your photo...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category:</label>
                        <select name="category" id="edit-category-${photoId}" class="form-input">
                            <option value="store">Store</option>
                            <option value="products">Products</option>
                            <option value="ambiance">Ambiance</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" name="is_featured" id="edit-featured-${photoId}" value="1">
                            <label for="edit-featured-${photoId}">⭐ Set as featured photo</label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Update Photo</button>
                        <button type="button" class="btn-secondary" onclick="this.closest('.modal-overlay').remove()">Cancel</button>
                    </div>
                </form>
            </div>
        `;

        document.body.appendChild(modal);

        // Load current photo data
        fetch(`/seller/photos/${photoId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
            })
            .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch photo data');
            }
            return response.json();
            })
            .then(data => {
            if (data.success && data.photo) {
                document.getElementById(`edit-caption-${photoId}`).value = data.photo.caption || '';
                document.getElementById(`edit-category-${photoId}`).value = data.photo.category || 'store';
                document.getElementById(`edit-featured-${photoId}`).checked = data.photo.is_featured;
            }
            })
            .catch(error => {
            console.error('Error loading photo data:', error);
            // Set default values if loading fails
            document.getElementById(`edit-category-${photoId}`).value = 'store';
            });

        // Handle form submission
        document.getElementById(`editForm-${photoId}`).addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('.btn-primary');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Updating...';
            submitBtn.disabled = true;

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                // Remove modal
                modal.remove();

                // Reload page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 500);
                } else {
                throw new Error('Update failed');
                }
            })
            .catch(error => {
                console.error('Error updating photo:', error);

                // Reset button
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;

                alert('Failed to update photo. Please try again.');
            });
        });

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
            modal.remove();
            }
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

        const uploadBtn = document.getElementById('uploadBtn');
        const progressDiv = document.getElementById('uploadProgress');

        uploadBtn.disabled = true;
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

            // Add location if available
            if (currentLocation) {
            formData.append('latitude', currentLocation.lat);
            formData.append('longitude', currentLocation.lng);
            formData.append('location_address', document.getElementById('locationAddress').textContent);
            }

            fetch('{{ route('seller.photos.store') }}', {
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
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                return response.json();
                } else {
                return {
                    success: true
                };
                }
            })
            .then(data => {
                uploadCount++;
                progressDiv.textContent = `Uploading ${uploadCount}/${totalPhotos} photos...`;

                if (uploadCount === totalPhotos) {
                if (hasError) {
                    progressDiv.textContent = 'Some photos failed to upload. Refreshing...';
                } else {
                    progressDiv.textContent = 'All photos uploaded successfully! 🎉';
                }
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
                }
            })
            .catch(error => {
                console.error('Error uploading photo:', error);
                uploadCount++;
                hasError = true;

                if (uploadCount === totalPhotos) {
                progressDiv.textContent = '❌ Some photos failed to upload. Please try again.';
                uploadBtn.disabled = false;
                setTimeout(() => {
                    progressDiv.style.display = 'none';
                }, 3000);
                }
            });
        });
        }

        // Show post details modal
        function showPostDetails(id, event) {
        if (event) event.stopPropagation();

        const photo = photoGroupsData.find(p => p.id === id);
        if (!photo) return;

        const modal = document.getElementById('post-detail-modal');
        const title = document.getElementById('post-detail-title');
        const meta = document.getElementById('post-detail-meta');
        const imageGrid = document.getElementById('post-detail-image-grid');
        const captionSection = document.getElementById('post-detail-caption');
        const captionContent = document.getElementById('post-detail-caption-content');
        const frozenBanner = document.getElementById('modal-frozen-banner');

        // Check if photo is frozen (matches admin's [FROZEN] prefix)
        const isFrozen = photo.caption.startsWith('[FROZEN] ');
        const cleanCaption = isFrozen ? photo.caption.substring(9) : photo.caption;

        // Show/hide frozen banner
        frozenBanner.style.display = isFrozen ? 'block' : 'none';

        // Set title
        title.textContent = cleanCaption || 'Store Photos';

        // Set meta information
        let metaHTML = `
            <div class="post-detail-meta-item">
                <span class="post-detail-meta-label">📅 Upload Date</span>
                <span class="post-detail-meta-value">${photo.created_at}</span>
            </div>
            <div class="post-detail-meta-item">
                <span class="post-detail-meta-label">⭐ Featured Status</span>
                <span class="post-detail-meta-value">${photo.is_featured ? 'Featured Photo ⭐' : 'Not Featured'}</span>
            </div>
            <div class="post-detail-meta-item">
                <span class="post-detail-meta-label">📂 Category</span>
                <span class="post-detail-meta-value">${photo.category}</span>
            </div>
        `;

        // Add location information if available
        if (photo.has_location && photo.latitude && photo.longitude) {
            metaHTML += `
                <div class="post-detail-meta-item">
                    <span class="post-detail-meta-label">📍 Location</span>
                    <span class="post-detail-meta-value">
                        <a href="https://www.google.com/maps?q=${photo.latitude},${photo.longitude}&z=15&t=m"
                        target="_blank"
                        style="color: #00b09b; text-decoration: none;">
                            ${photo.location_address || `${parseFloat(photo.latitude).toFixed(4)}, ${parseFloat(photo.longitude).toFixed(4)}`}
                            🔗
                        </a>
                    </span>
                </div>
            `;
        }

        meta.innerHTML = metaHTML;

        // Set image grid
        imageGrid.className = 'post-detail-image-grid single';
        imageGrid.innerHTML = '';

        const imageDiv = document.createElement('div');
        imageDiv.className = 'post-detail-image-item';
        imageDiv.innerHTML = `
            <img src="${photo.url}" alt="${cleanCaption || 'Store photo'}" onclick="viewPhoto('${photo.url}', event)" style="cursor: zoom-in;">
        `;
        imageGrid.appendChild(imageDiv);

        // Set caption
        if (cleanCaption) {
            captionContent.textContent = cleanCaption;
            captionSection.style.display = 'block';
        } else {
            captionSection.style.display = 'none';
        }

        // Show modal
        modal.classList.add('active');
        }

        // Close post detail modal
        function closePostDetailModal(event) {
        if (!event || event.target === document.getElementById('post-detail-modal')) {
            document.getElementById('post-detail-modal').classList.remove('active');
        }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
        // Set default location
        currentLocation = {
            lat: 11.5564,
            lng: 104.9282
        }; // Phnom Penh coordinates

        // Add fade-in animation to elements
        const fadeElements = document.querySelectorAll('.fade-in');
        fadeElements.forEach((el, index) => {
            el.style.opacity = '0';
            setTimeout(() => {
            el.style.opacity = '1';
            }, index * 100);
        });

           console.log('Photo gallery initialized with', photoGroupsData.length, 'photo groups');
        });

        // Scroll to upload section
        function scrollToUpload() {
        const uploadCard = document.querySelector('.upload-card');
        if (uploadCard) {
            uploadCard.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
            });

            // Focus on the upload area
            setTimeout(() => {
            const uploadArea = document.getElementById('dropArea');
            if (uploadArea) {
                uploadArea.style.transform = 'scale(1.02)';
                uploadArea.style.borderColor = '#009688';
                setTimeout(() => {
                uploadArea.style.transform = 'scale(1)';
                uploadArea.style.borderColor = '#00b09b';
                }, 300);
            }
            }, 500);
        }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
        // Escape key - close any open modal
        if (e.key === 'Escape') {
            const postModal = document.getElementById('post-detail-modal');
            if (postModal && postModal.classList.contains('active')) {
            closePostDetailModal();
            }
        }
        });
    </script>
    @endsection
