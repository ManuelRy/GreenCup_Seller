{{-- <!-- Enhanced Footer Component -->
<footer class="app-footer">
    <div class="footer-content">
        <div class="footer-info">
            <p>&copy; {{ date('Y') }} Green Cup. All rights reserved.</p>
            <p class="footer-version">Version 1.0.0 • Made with 💚</p>
        </div>
        <div class="footer-links">
            <a href="#" class="footer-link">Privacy Policy</a>
            <a href="#" class="footer-link">Terms of Service</a>
            <a href="#" class="footer-link">Support</a>
        </div>
    </div>
</footer>

<!-- Enhanced Footer Styles -->
<style>
    .app-footer {
        margin-top: auto;
        padding: 24px 20px;
        background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.05) 100%);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-top: 1px solid rgba(255,255,255,0.25);
        position: relative;
        overflow: hidden;
    }

    .app-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        animation: footerShine 4s infinite;
        pointer-events: none;
    }

    @keyframes footerShine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        position: relative;
        z-index: 2;
    }

    .footer-info {
        text-align: left;
    }

    .footer-info p {
        color: rgba(255,255,255,0.9);
        font-size: 14px;
        font-weight: 500;
        margin: 0;
        line-height: 1.5;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .footer-version {
        font-size: 12px !important;
        opacity: 0.8;
        font-weight: 400 !important;
        margin-top: 2px !important;
    }

    .footer-links {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .footer-link {
        color: rgba(255,255,255,0.85);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 6px 12px;
        border-radius: 8px;
        position: relative;
        overflow: hidden;
    }

    .footer-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .footer-link:hover::before {
        opacity: 1;
    }

    .footer-link:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .app-footer {
            padding: 20px 16px;
        }

        .footer-content {
            flex-direction: column;
            text-align: center;
            gap: 16px;
        }

        .footer-links {
            justify-content: center;
            gap: 16px;
        }

        .footer-info p {
            font-size: 13px;
        }
    }

    @media (max-width: 480px) {
        .footer-links {
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }
    }
</style> --}}
