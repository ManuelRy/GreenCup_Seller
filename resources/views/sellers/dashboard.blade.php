@extends('layouts.dashboard')

@section('title', 'Dashboard - Green Cup App')

@push('styles')
<style>
/* Enhanced Dashboard Styles */
.dashboard-container {
    min-height: 100vh;
    background: linear-gradient(-45deg, #00b09b, #00c9a1, #00d9a6, #00e8ab, #00b09b);
    background-size: 400% 400%;
    animation: gradientShift 20s ease infinite;
    padding-bottom: 40px;
    position: relative;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Main Content */
.main-content {
    max-width: 1100px;
    margin: 0 auto;
    padding: 32px 20px;
    position: relative;
    z-index: 10;
}

/* Enhanced Points Card */
.points-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border-radius: 20px;
    padding: 32px;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.3);
    margin-bottom: 32px;
    animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    z-index: 15;
}

.points-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent 30%, rgba(0,176,155,0.1) 50%, transparent 70%);
    transform: rotate(45deg);
    animation: shimmer 4s infinite;
}

@keyframes shimmer {
    0% { transform: rotate(45deg) translateX(-200%); }
    100% { transform: rotate(45deg) translateX(200%); }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.points-value {
    font-size: 48px;
    font-weight: 800;
    background: linear-gradient(135deg, #00b09b 0%, #059669 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 12px;
    position: relative;
    z-index: 2;
}

.points-label {
    color: #64748b;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    z-index: 2;
}

/* Enhanced Progress Card */
.progress-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border-radius: 20px;
    padding: 32px;
    margin-bottom: 32px;
    box-shadow:
        0 20px 60px rgba(0,0,0,0.12),
        0 8px 32px rgba(0,0,0,0.08),
        inset 0 1px 0 rgba(255,255,255,0.9);
    border: 1px solid rgba(255,255,255,0.3);
    animation: slideInUp 0.8s ease-out 0.2s backwards;
}

.rank-badge {
    display: inline-block;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
}

.progress-bar {
    width: 100%;
    height: 12px;
    background: #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    margin: 16px 0;
    position: relative;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #00b09b 0%, #00d9a6 100%);
    border-radius: 10px;
    transition: width 2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: progressShine 2s infinite;
}

@keyframes progressShine {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Enhanced Stats and Actions */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border-radius: 18px;
    padding: 28px 24px;
    text-align: center;
    box-shadow:
        0 15px 40px rgba(0,0,0,0.1),
        0 6px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(255,255,255,0.3);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow:
        0 25px 60px rgba(0,0,0,0.15),
        0 10px 30px rgba(0,0,0,0.1);
}

.action-btn {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 14px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    position: relative;
    overflow: hidden;
}

.action-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.6s ease;
}

.action-btn:hover::before {
    left: 100%;
}

.action-btn:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 40px rgba(59, 130, 246, 0.4);
    color: white;
    text-decoration: none;
}

.fade-in {
    animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateY(0) scale(1) !important;
    pointer-events: auto !important;
}

.dropdown-menu {
    padding: 12px 0;
    overflow: visible;
    position: relative;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    color: #374151;
    text-decoration: none;
    transition: all 0.2s ease;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    white-space: nowrap;
    min-height: 44px;
    position: relative;
}

.dropdown-item:hover {
    background: #f3f4f6;
    color: #1f2937;
    text-decoration: none;
}

.dropdown-item.logout {
    color: #dc2626;
    border-top: 1px solid #e5e7eb;
}

.dropdown-item.logout:hover {
    background: #fef2f2;
    color: #dc2626;
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 600;
    color: #333;
    cursor: pointer;
    transition: all 0.2s ease;
}

.user-avatar:hover {
    transform: scale(1.05);
}

.user-name {
    color: white;
    font-size: 14px;
    font-weight: 500;
}

.dropdown-arrow {
    transition: transform 0.2s ease;
}

.user-section.active .dropdown-arrow {
    transform: rotate(180deg);
}

/* Main Content */
.main-content {
    max-width: 1000px;
    margin: 0 auto;
    padding: 24px 16px;
}

/* Points Card */
.points-card {
    background: white;
    border-radius: 20px;
    padding: 32px;
    text-align: center;
    margin-bottom: 24px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    position: relative;
    overflow: hidden;
}

.points-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: conic-gradient(from 0deg, #00b09b, #00cdac, #00dfa8, #00b09b);
    opacity: 0.05;
    animation: rotate 20s linear infinite;
}

@keyframes rotate {
    to { transform: rotate(360deg); }
}

.points-value {
    font-size: 56px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1;
    margin-bottom: 8px;
    position: relative;
    z-index: 2;
}

.points-label {
    font-size: 12px;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    z-index: 2;
}

/* Progress Section */
.progress-card {
    background: white;
    border-radius: 20px;
    padding: 20px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 2px solid #f0f0f0;
}

.progress-section {
    position: relative;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.rank-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    border: 1px solid #f59e0b;
}

.progress-text {
    font-size: 12px;
    color: #666;
    font-weight: 500;
}

.progress-bar {
    width: 100%;
    height: 10px;
    background: #e5e7eb;
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 12px;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%);
    border-radius: 5px;
    transition: width 0.8s ease;
    box-shadow: 0 2px 4px rgba(251, 191, 36, 0.4);
}

.progress-labels {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: #999;
    font-weight: 500;
}

/* Receipt Management Card */
.receipt-stats-card {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.2);
    position: relative;
    overflow: hidden;
}

.receipt-stats-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -30%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
    transform: rotate(15deg);
    pointer-events: none;
}

.receipt-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    position: relative;
    z-index: 2;
}

.receipt-title {
    font-size: 18px;
    font-weight: 700;
    color: #064e3b;
    display: flex;
    align-items: center;
    gap: 10px;
}

.receipt-icon {
    font-size: 22px;
}

.receipt-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
    position: relative;
    z-index: 15;
}

.receipt-stat {
    text-align: center;
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border: 1px solid rgba(16, 185, 129, 0.1);
}

.receipt-stat-value {
    font-size: 36px;
    font-weight: 800;
    color: #10b981;
    line-height: 1;
    margin-bottom: 6px;
}

.receipt-stat-label {
    font-size: 12px;
    color: #047857;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.receipt-actions {
    display: flex;
    gap: 12px;
    position: relative;
    z-index: 2;
}

.receipt-btn {
    flex: 1;
    padding: 14px 18px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.receipt-btn-primary {
    background: #10b981;
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.receipt-btn-primary:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    color: white;
    text-decoration: none;
}

.receipt-btn-secondary {
    background: white;
    color: #047857;
    border: 2px solid rgba(16, 185, 129, 0.3);
}

.receipt-btn-secondary:hover {
    background: #f0fdf4;
    color: #064e3b;
    text-decoration: none;
    transform: translateY(-2px);
    border-color: rgba(16, 185, 129, 0.5);
}

/* Analytics Card */
.analytics-card {
    background: white;
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.analytics-header {
    text-align: center;
    margin-bottom: 24px;
}

.analytics-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

/* Donut Chart Container */
.chart-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 24px;
    position: relative;
}

.donut-chart {
    width: 200px;
    height: 200px;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
}

.chart-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.chart-value {
    font-size: 36px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1;
}

.chart-label {
    font-size: 12px;
    color: #666;
    margin-top: 4px;
    font-weight: 500;
}

.chart-legend {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 20px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #666;
    font-weight: 500;
}

.legend-dot {
    width: 14px;
    height: 14px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.legend-dot.green {
    background: #10b981;
}

.legend-dot.red {
    background: #ef4444;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 24px;
    position: relative;
    z-index: 15;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    text-align: center;
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.stat-title {
    font-size: 14px;
    color: #666;
    font-weight: 500;
}

.stat-icon {
    font-size: 20px;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1;
    margin-bottom: 4px;
}

.stat-subtitle {
    font-size: 12px;
    color: #999;
}

/* Quick Actions Grid */
.actions-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

@media (max-width: 768px) {
    .actions-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
}

@media (max-width: 480px) {
    .actions-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
}

.action-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    padding: 24px;
    border-radius: 16px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255,255,255,0.3);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    position: relative;
    z-index: 15;
}

.action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    color: #333;
    text-decoration: none;
    border-color: #00b09b;
}

.action-card.receipt-action {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 2px solid rgba(16, 185, 129, 0.2);
}

.action-card.receipt-action:hover {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    border-color: #10b981;
}

.action-card.scanner-action {
    background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
    border: 2px solid rgba(139, 92, 246, 0.2);
}

.action-card.scanner-action:hover {
    background: linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%);
    border-color: #8b5cf6;
}

.action-card.rewards-action {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 2px solid rgba(245, 158, 11, 0.2);
}

.action-card.rewards-action:hover {
    background: linear-gradient(135deg, #fde68a 0%, #fcd34d 100%);
    border-color: #f59e0b;
}

.action-card.reports-action {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border: 2px solid rgba(14, 165, 233, 0.2);
}

.action-card.reports-action:hover {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    border-color: #0ea5e9;
}

.action-card.location-action {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 2px solid rgba(34, 197, 94, 0.2);
}

.action-card.location-action:hover {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    border-color: #22c55e;
}

.action-icon {
    font-size: 28px;
    margin-bottom: 8px;
}

.action-label {
    font-size: 13px;
    font-weight: 600;
    line-height: 1.2;
}

/* Recent Activity */
.activity-card {
    background: white;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.activity-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.view-all {
    font-size: 14px;
    color: #00b09b;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s ease;
}

.view-all:hover {
    color: #009688;
    text-decoration: none;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 12px;
    border-radius: 12px;
    transition: background-color 0.2s ease;
}

.activity-item:hover {
    background: #f8f9fa;
}

.activity-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.activity-details {
    flex: 1;
}

.activity-name {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
}

.activity-desc {
    font-size: 12px;
    color: #666;
}

.activity-points {
    font-size: 14px;
    font-weight: 700;
    color: #10b981;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 48px 24px;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.empty-text {
    font-size: 14px;
    color: #666;
    margin-bottom: 24px;
    line-height: 1.5;
}

.btn-primary {
    background: linear-gradient(135deg, #00b09b, #00cdac);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 176, 155, 0.3);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #009688, #00b09b);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 176, 155, 0.4);
    color: white;
    text-decoration: none;
}

/* Utility Classes */
.text-center { text-align: center; }
.text-muted { color: #666; }

/* Mobile Optimizations */
@media (max-width: 1024px) {
    .stats-row {
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }
    .receipt-stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
    }
}

@media (max-width: 768px) {
    .main-content {
        padding: 24px 16px;
    }
    .points-card {
        padding: 28px 20px;
    }
    .points-value {
        font-size: 42px;
    }
    .progress-card, .analytics-card, .activity-card {
        padding: 20px;
    }
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    .stats-row {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .receipt-stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .chart-legend {
        flex-direction: column;
        gap: 12px;
        align-items: flex-start;
        padding-left: 20px;
    }
    .actions-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
}

@media (max-width: 640px) {
    .main-content {
        padding: 20px 12px;
    }
    .points-card {
        padding: 24px 16px;
        margin-bottom: 20px;
    }
    .points-value {
        font-size: 36px;
    }
    .points-label {
        font-size: 13px;
    }
    .stat-value {
        font-size: 24px;
    }
    .stat-title {
        font-size: 12px;
    }
    .stats-grid {
        grid-template-columns: 1fr;
    }
    .chart-legend {
        gap: 16px;
        font-size: 13px;
    }
    .receipt-stats-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    .receipt-actions {
        flex-direction: column;
        gap: 10px;
    }
    .receipt-btn {
        width: 100%;
    }
    .progress-header {
        flex-direction: column;
        gap: 12px;
        text-align: center;
        align-items: center;
    }
    .rank-badge {
        font-size: 12px;
        padding: 6px 14px;
    }
    .progress-text {
        font-size: 11px;
    }
    .activity-item {
        flex-wrap: wrap;
    }
    .activity-points {
        width: 100%;
        text-align: left;
        margin-top: 8px;
        padding-left: 56px;
    }
}

@media (max-width: 480px) {
    .main-content {
        padding: 16px 10px;
    }
    .points-value {
        font-size: 32px;
    }
    .points-card, .progress-card, .analytics-card, .receipt-stats-card, .activity-card {
        padding: 16px;
        border-radius: 16px;
    }
    .actions-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    .action-card {
        padding: 20px 16px;
    }
    .action-icon {
        font-size: 24px;
    }
    .action-label {
        font-size: 12px;
    }
    .donut-chart {
        width: 160px;
        height: 160px;
    }
    .chart-value {
        font-size: 28px;
    }
    .receipt-stat-value {
        font-size: 28px;
    }
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    .stat-card {
        padding: 16px;
    }
}

@media (max-width: 360px) {
    .points-value {
        font-size: 28px;
    }
    .stat-value {
        font-size: 20px;
    }
    .actions-grid {
        grid-template-columns: 1fr;
        gap: 8px;
    }
    .receipt-stats-grid {
        gap: 10px;
    }
}

/* Animations */
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

.fade-in {
    animation: fadeIn 0.6s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.slide-in {
    animation: slideIn 0.5s ease-out;
}
</style>
@endpush

@section('content')
<!-- Main Content -->
<main class="main-content">
        <!-- Points Card -->
        <div class="points-card fade-in">
            <div class="points-value" id="totalPoints">{{ number_format($totalRankPoints) }}</div>
            <div class="points-label">Total Points Earned</div>
        </div>

        <!-- Progress Section -->
        @if($currentRank)
        <div class="progress-card fade-in">
            <div class="progress-section">
                <div class="progress-header">
                    <span class="rank-badge">
                        @switch($currentRank->name)
                            @case('Platinum') 💎 @break
                            @case('Gold') 🏆 @break
                            @case('Silver') 🥈 @break
                            @case('Bronze') 🥉 @break
                            @case('Standard') ⭐ @break
                            @default ⭐
                        @endswitch
                        {{ $currentRank->name }} Seller
                    </span>
                    <span class="progress-text">
                        @if($nextRank)
                            {{ number_format($pointsToNext) }} points to {{ $nextRank->name }}
                        @else
                            🎉 Maximum rank achieved!
                        @endif
                    </span>
                </div>

                @if($nextRank)
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ min(100, (($totalRankPoints - $currentRank->min_points) / ($nextRank->min_points - $currentRank->min_points)) * 100) }}%"></div>
                </div>
                <div class="progress-labels">
                    <span>{{ $currentRank->name }} ({{ number_format($currentRank->min_points) }})</span>
                    <span>{{ $nextRank->name }} ({{ number_format($nextRank->min_points) }})</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Receipt Management Card -->
        <div class="receipt-stats-card fade-in">
            <div class="receipt-header">
                <div class="receipt-title">
                    <span class="receipt-icon">📄</span>
                    Receipt Management
                </div>
            </div>

            <div class="receipt-stats-grid">
                @php
                    try {
                        $pendingReceipts = DB::table('pending_transactions')
                            ->where('seller_id', Auth::guard('seller')->user()->id)
                            ->where('status', 'pending')
                            ->count();
                        $claimedToday = DB::table('pending_transactions')
                            ->where('seller_id', Auth::guard('seller')->user()->id)
                            ->where('status', 'claimed')
                            ->whereDate('claimed_at', today())
                            ->count();
                    } catch (\Exception $e) {
                        $pendingReceipts = 0;
                        $claimedToday = 0;
                    }
                @endphp
                <div class="receipt-stat">
                    <div class="receipt-stat-value">{{ $pendingReceipts }}</div>
                    <div class="receipt-stat-label">Pending</div>
                </div>
                <div class="receipt-stat">
                    <div class="receipt-stat-value">{{ $claimedToday }}</div>
                    <div class="receipt-stat-label">Claimed Today</div>
                </div>
            </div>

            <div class="receipt-actions">
                <a href="{{ route('seller.receipts.index') }}" class="receipt-btn receipt-btn-secondary">
                    <span>📋</span>
                    View All Receipts
                </a>
                <a href="{{ route('seller.receipts.create') }}" class="receipt-btn receipt-btn-primary">
                    <span>➕</span>
                    Create Receipt
                </a>
            </div>
        </div>

        <!-- Analytics Card -->
        @if($totalTransactions > 0)
        <div class="analytics-card fade-in">
            <div class="analytics-header">
                <h3 class="analytics-title">📊 Points Analytics</h3>
            </div>

            <div class="chart-container">
                <svg class="donut-chart" viewBox="0 0 200 200">
                    <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="20"/>
                    <circle cx="100" cy="100" r="80" fill="none"
                            stroke="#10b981"
                            stroke-width="20"
                            stroke-dasharray="{{ ($givingPercentage / 100) * 502.65 }} 502.65"
                            stroke-dashoffset="0"
                            transform="rotate(-90 100 100)"/>
                    <circle cx="100" cy="100" r="80" fill="none"
                            stroke="#ef4444"
                            stroke-width="20"
                            stroke-dasharray="{{ ($redemptionPercentage / 100) * 502.65 }} 502.65"
                            stroke-dashoffset="-{{ ($givingPercentage / 100) * 502.65 }}"
                            transform="rotate(-90 100 100)"/>
                </svg>
                <div class="chart-center">
                    <div class="chart-value">{{ number_format($totalActivity) }}</div>
                    <div class="chart-label">Total Activity</div>
                </div>
            </div>

            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-dot green"></span>
                    <span>Points Given ({{ number_format($pointsGiven) }})</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot red"></span>
                    <span>Points from Redemptions ({{ number_format($pointsFromRedemptions) }})</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Stats Grid -->
        <div class="stats-grid fade-in">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Total Customers</span>
                    <span class="stat-icon">👥</span>
                </div>
                <div class="stat-value">{{ number_format($totalCustomers) }}</div>
                <div class="stat-subtitle">Unique customers served</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Total Transactions</span>
                    <span class="stat-icon">📋</span>
                </div>
                <div class="stat-value">{{ number_format($totalTransactions) }}</div>
                <div class="stat-subtitle">All time transactions</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="actions-grid fade-in">
            <a href="{{ route('seller.account') }}" class="action-card">
                <div class="action-icon">👤</div>
                <div class="action-label">Account</div>
            </a>

            <a href="{{ route('seller.receipts.index') }}" class="action-card receipt-action">
                <div class="action-icon">📄</div>
                <div class="action-label">Receipts</div>
            </a>

            <a href="{{ route('item.index') }}" class="action-card">
                <div class="action-icon">📦</div>
                <div class="action-label">Items</div>
            </a>

            <a href="{{ route('reward.index') }}" class="action-card rewards-action">
                <div class="action-icon">🎁</div>
                <div class="action-label">Rewards</div>
            </a>

            <a href="{{ route('location.show') }}" class="action-card location-action">
                <div class="action-icon">📍</div>
                <div class="action-label">Location</div>
            </a>

            <a href="{{ route('report.index') }}" class="action-card reports-action">
                <div class="action-icon">📊</div>
                <div class="action-label">Reports</div>
            </a>
        </div>

        <!-- Recent Activity -->
        <div class="activity-card fade-in">
            <div class="activity-header">
                <h3 class="activity-title">⚡ Recent Activity</h3>
                @if($totalTransactions > 0)
                <a href="{{ route('seller.activity') }}" class="view-all">View All →</a>
                @endif
            </div>

            @if($totalTransactions > 0)
                @php
                    $recentTransactions = collect();
                    try {
                        $recentTransactions = DB::table('point_transactions')
                            ->join('consumers', 'point_transactions.consumer_id', '=', 'consumers.id')
                            ->leftJoin('qr_codes', 'point_transactions.qr_code_id', '=', 'qr_codes.id')
                            ->leftJoin('items', 'qr_codes.item_id', '=', 'items.id')
                            ->where('point_transactions.seller_id', $seller->id)
                            ->select([
                                'point_transactions.id',
                                'point_transactions.points',
                                'point_transactions.type',
                                'point_transactions.created_at',
                                'consumers.full_name as consumer_name',
                                'items.name as item_name'
                            ])
                            ->orderBy('point_transactions.created_at', 'desc')
                            ->limit(5)
                            ->get();
                    } catch (\Exception $e) {
                        $recentTransactions = collect();
                    }
                @endphp

                @if($recentTransactions->count() > 0)
                <div class="activity-list">
                    @foreach($recentTransactions as $transaction)
                    <div class="activity-item slide-in">
                        <div class="activity-avatar">
                            @if($transaction->type === 'earn')
                                ✅
                            @else
                                💳
                            @endif
                        </div>
                        <div class="activity-details">
                            <div class="activity-name">{{ $transaction->consumer_name ?? 'Customer' }}</div>
                            <div class="activity-desc">
                                @if($transaction->type === 'earn')
                                    Earned points • {{ $transaction->item_name ?? 'Item' }}
                                @else
                                    Redeemed points • {{ $transaction->item_name ?? 'Item' }}
                                @endif
                            </div>
                        </div>
                        <div class="activity-points">
                            {{ $transaction->points }} pts
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-text">No recent transactions to display</div>
                </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">🚀</div>
                    <h4 class="empty-title">Ready to Get Started?</h4>
                    <p class="empty-text">Create your first receipt to start tracking your green impact and helping customers earn points!</p>
                    <a href="{{ route('seller.receipts.create') }}" class="btn-primary">Create First Receipt</a>
                </div>
            @endif
        </div>
    </main>
@endsection

@push('scripts')
<script>
// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    const totalPointsEl = document.getElementById('totalPoints');
    if (totalPointsEl) {
        const currentValue = parseInt(totalPointsEl.textContent.replace(/,/g, ''));
        totalPointsEl.textContent = '0';

        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / 2000, 1);
            const current = Math.floor(progress * currentValue);
            totalPointsEl.textContent = current.toLocaleString();
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }
});
</script>
@endpush
