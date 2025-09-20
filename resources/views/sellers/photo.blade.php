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

    /* Container with Gradient Background - Same as Dashboard */
    .dashboard-container {
      min-height: 100vh;
      background: linear-gradient(135deg, #00b09b 0%, #00cdac 50%, #00dfa8 100%);
      padding-bottom: 40px;
    }

    /* Header - Receipt Management Style */
    .dashboard-header {
      background: #374151;
      padding: 20px;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .header-content {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .header-back-btn {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.1);
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
    }

    .header-back-btn:hover {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      text-decoration: none;
    }

    .header-title-section {
      color: white;
    }

    .app-title {
      font-size: 24px;
      font-weight: 700;
      margin: 0 0 4px 0;
      color: white;
    }

    .app-subtitle {
      font-size: 14px;
      color: rgba(255, 255, 255, 0.8);
      margin: 0;
    }

    .back-button {
      background: linear-gradient(135deg, #00b09b, #00cdac);
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
      box-shadow: 0 4px 12px rgba(0, 176, 155, 0.3);
    }

    .back-button:hover {
      background: linear-gradient(135deg, #009688, #00b09b);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 176, 155, 0.4);
      color: white;
      text-decoration: none;
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

    @media (max-width: 1024px) {
      .two-column-layout {
        grid-template-columns: 1fr;
        gap: 20px;
      }
    }

    /* Upload Card */
    .upload-card {
      background: white;
      border-radius: 20px;
      padding: 20px;
      margin-bottom: 0;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border: 2px solid #f0f0f0;
      height: fit-content;
    }

    .upload-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 20px;
    }

    .user-avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: linear-gradient(135deg, #00b09b, #00cdac);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 20px;
      font-weight: 600;
    }

    .user-info h3 {
      font-size: 16px;
      font-weight: 600;
      color: #333;
      margin-bottom: 2px;
    }

    .user-info p {
      font-size: 13px;
      color: #666;
    }

    .caption-input {
      width: 100%;
      border: none;
      padding: 16px 0;
      font-size: 16px;
      color: #333;
      resize: none;
      min-height: 80px;
      font-family: inherit;
      background: transparent;
    }

    .caption-input:focus {
      outline: none;
    }

    .caption-input::placeholder {
      color: #999;
    }

    /* Upload Area */
    .upload-section {
      border-top: 1px solid #f0f0f0;
      padding-top: 20px;
    }

    .upload-area {
      border: 2px dashed #00b09b;
      border-radius: 16px;
      padding: 40px 20px;
      text-align: center;
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
      cursor: pointer;
      transition: all 0.3s ease;
      margin-bottom: 20px;
    }

    .upload-area:hover {
      border-color: #009688;
      background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
      transform: translateY(-2px);
    }

    .upload-area.dragover {
      border-color: #009688;
      background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    }

    .upload-icon {
      font-size: 48px;
      margin-bottom: 16px;
      opacity: 0.7;
    }

    .upload-text {
      font-size: 18px;
      color: #00b09b;
      margin-bottom: 8px;
      font-weight: 600;
    }

    .upload-subtext {
      font-size: 14px;
      color: #666;
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
      background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
      border: 2px solid rgba(59, 130, 246, 0.2);
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 20px;
      position: relative;
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
      font-weight: 600;
      color: #1e40af;
      margin-bottom: 4px;
    }

    .location-address {
      font-size: 14px;
      color: #374151;
      margin-bottom: 2px;
      font-weight: 500;
    }

    .location-coords {
      font-size: 12px;
      color: #6b7280;
      font-family: monospace;
    }

    .location-map {
      width: 80px;
      height: 80px;
      border-radius: 8px;
      overflow: hidden;
      cursor: pointer;
      position: relative;
      border: 2px solid rgba(59, 130, 246, 0.3);
      transition: all 0.2s ease;
      background: #f3f4f6;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .location-map:hover {
      transform: scale(1.05);
      border-color: rgba(59, 130, 246, 0.6);
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
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
      top: 8px;
      right: 8px;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.3);
      color: #dc2626;
      font-size: 12px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
    }

    .remove-location-btn:hover {
      background: rgba(239, 68, 68, 0.2);
      transform: scale(1.1);
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
      padding: 12px;
      border: none;
      background: #f8f9fa;
      color: #666;
      font-size: 14px;
      font-weight: 600;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .action-btn:hover {
      background: #e9ecef;
      color: #333;
    }

    .action-btn.active {
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
      color: #00b09b;
      border: 1px solid rgba(0, 176, 155, 0.2);
    }

    /* Options Panel */
    .options-panel {
      background: #f8f9fa;
      padding: 16px;
      border-radius: 12px;
      margin-bottom: 20px;
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
      accent-color: #00b09b;
    }

    .checkbox-group label {
      color: #333;
      font-weight: 500;
    }

    /* Upload Button */
    .upload-btn {
      background: linear-gradient(135deg, #00b09b, #00cdac);
      color: white;
      padding: 16px 32px;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
      box-shadow: 0 4px 15px rgba(0, 176, 155, 0.3);
    }

    .upload-btn:hover {
      background: linear-gradient(135deg, #009688, #00b09b);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 176, 155, 0.4);
    }

    .upload-btn:disabled {
      background: #e4e6ea;
      color: #bcc0c4;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
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
      background: white;
      border: 1px solid #f0f0f0;
      border-radius: 12px;
      overflow: hidden;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
    }

    .photo-post-thumbnail:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      border-color: #00b09b;
    }

    .post-thumbnail-container {
      display: flex;
      gap: 12px;
      padding: 12px;
      align-items: center;
    }

    .post-thumbnail-image {
      width: 60px;
      height: 60px;
      border-radius: 8px;
      overflow: hidden;
      position: relative;
      flex-shrink: 0;
      background: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
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
      top: 4px;
      left: 4px;
      background: linear-gradient(135deg, #FFD700, #FFA500);
      color: white;
      padding: 2px 4px;
      border-radius: 6px;
      font-size: 8px;
      font-weight: 600;
    }

    .post-thumbnail-info {
      flex: 1;
      min-width: 0;
    }

    .thumbnail-title {
      font-size: 14px;
      font-weight: 600;
      color: #333;
      margin-bottom: 4px;
      line-height: 1.3;
      word-wrap: break-word;
    }

    .thumbnail-meta {
      font-size: 11px;
      color: #666;
      line-height: 1.4;
    }

    .thumbnail-actions {
      display: flex;
      gap: 6px;
      padding: 8px 12px;
      border-top: 1px solid #f0f0f0;
      background: #f9f9f9;
      opacity: 0;
      transition: opacity 0.2s ease;
    }

    .photo-post-thumbnail:hover .thumbnail-actions {
      opacity: 1;
    }

    .thumbnail-action-btn {
      padding: 6px 10px;
      border: none;
      border-radius: 6px;
      background: #f0f0f0;
      color: #666;
      font-size: 11px;
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .thumbnail-action-btn:hover {
      background: #e0e0e0;
      color: #333;
    }

    .thumbnail-action-btn.delete-btn:hover {
      background: #fee2e2;
      color: #dc2626;
    }

    /* Post Detail Modal */
    .post-detail-modal {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
      padding: 20px;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }

    .post-detail-modal.active {
      opacity: 1;
      visibility: visible;
    }

    .post-detail-content {
      background: white;
      border-radius: 20px;
      max-width: 800px;
      width: 100%;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
      transform: scale(0.9);
      transition: transform 0.3s ease;
    }

    .post-detail-modal.active .post-detail-content {
      transform: scale(1);
    }

    .post-detail-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 24px 32px;
      border-bottom: 1px solid #f0f0f0;
    }

    .post-detail-title {
      font-size: 24px;
      font-weight: 700;
      color: #333;
    }

    .post-detail-close {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #f8f9fa;
      border: none;
      color: #666;
      font-size: 18px;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .post-detail-close:hover {
      background: #e9ecef;
      color: #333;
    }

    .post-detail-body {
      padding: 32px;
    }

    .post-detail-meta {
      background: #f8f9fa;
      padding: 16px;
      border-radius: 12px;
      margin-bottom: 24px;
    }

    .post-detail-meta-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid #e9ecef;
    }

    .post-detail-meta-item:last-child {
      border-bottom: none;
    }

    .post-detail-meta-label {
      font-size: 14px;
      font-weight: 600;
      color: #666;
    }

    .post-detail-meta-value {
      font-size: 14px;
      color: #333;
    }

    .post-detail-images {
      margin-bottom: 24px;
    }

    .post-detail-images-title {
      font-size: 18px;
      font-weight: 600;
      color: #333;
      margin-bottom: 16px;
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
      font-size: 16px;
      font-weight: 600;
      color: #333;
      margin-bottom: 12px;
    }

    .post-detail-caption-content {
      font-size: 16px;
      color: #666;
      line-height: 1.6;
      padding: 16px;
      background: #f8f9fa;
      border-radius: 12px;
    }

    /* Gallery Section */
    .gallery-card {
      background: white;
      border-radius: 20px;
      padding: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      height: fit-content;
      border: 2px solid #f0f0f0;
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
      color: #333;
      display: flex;
      align-items: center;
      gap: 8px;
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

    /* Alert Messages */
    .alert {
      padding: 16px 20px;
      border-radius: 12px;
      margin-bottom: 24px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .alert-success {
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
      color: #047857;
      border: 1px solid rgba(4, 120, 87, 0.2);
    }

    .alert-error {
      background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
      color: #dc2626;
      border: 1px solid rgba(220, 38, 38, 0.2);
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
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.9);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
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
          <div class="header-title-section">
            <h1 class="app-title">📸 Store Gallery Manager</h1>
            <p class="app-subtitle">Share your store photos with customers and showcase your green impact</p>
          </div>
        </div>
        <a href="{{ route('dashboard') }}" class="back-button">
          ← Back to Dashboard
        </a>
      </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Alerts -->
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
            <div class="upload-area" onclick="triggerFileInput()" id="dropArea">
              <div class="upload-icon">📸</div>
              <div class="upload-text">Add photos to your post</div>
              <div class="upload-subtext">Drag and drop or click to select photos (Max 5MB each)</div>
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
              </h2>
              <div class="gallery-header-actions">
                <span class="gallery-count">{{ $photos->count() }} photos</span>
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
                <div class="photo-post-thumbnail" onclick="showPostDetails({{ $photo->id }})">
                  <div class="post-thumbnail-container">
                    <div class="post-thumbnail-image">
                      <img src="{{ $photo->photo_url }}" alt="{{ $photo->caption ?: 'Store photo' }}"
                        onerror="this.style.display='none'; this.parentElement.classList.add('img-error');">
                      {{-- @if (count($photo) > 1)
                                        <div class="thumbnail-count">+{{ count($photo) - 1 }}</div>
                                    @endif --}}
                      @if ($photo->is_featured)
                        <div class="thumbnail-featured">⭐</div>
                      @endif
                    </div>
                    <div class="post-thumbnail-info">
                      <div class="thumbnail-title">
                        @if ($photo->caption)
                          {{ limitString($photo->caption, 40) }}
                        @else
                          Store Photos
                        @endif
                      </div>
                      <div class="thumbnail-meta">
                        📅 {{ $photo->created_at->format('M j, Y') }} •
                        {{-- {{ count($photo) }} photo{{ count($photo) > 1 ? 's' : '' }} --}}
                        @if ($photo->where('is_featured', true)->count() > 0)
                          • ⭐ Featured
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="thumbnail-actions">
                    <button class="thumbnail-action-btn" onclick="showPostDetails({{ $photo->id }}, event)" title="View Details">
                      👁️
                    </button>
                    <button class="thumbnail-action-btn" onclick="editPhoto({{ $photo->id }}, event)" title="Edit">
                      ✏️
                    </button>
                    <form action="{{ route('seller.photos.destroy', $photo->id) }}" method="POST" style="display: inline;"
                      onsubmit="return confirm('Are you sure you want to delete this photo?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="thumbnail-action-btn delete-btn" onclick="event.stopPropagation();" title="Delete">
                        🗑️
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

    let selectedFiles = [];
    let photoCounter = 0;
    let currentLocation = null;

    // Photo groups data for modal display
    const photoGroupsData = [
      @foreach ($photos as $p)
        {
          id: {{ $p->id }},
          url: "{{ $p->photo_url }}",
          caption: "{{ $p->caption ?: '' }}",
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
              // Show success message
              const successMsg = document.createElement('div');
              successMsg.className = 'alert alert-success';
              successMsg.style.position = 'fixed';
              successMsg.style.top = '20px';
              successMsg.style.right = '20px';
              successMsg.style.zIndex = '10000';
              successMsg.innerHTML = '✅ Photo updated successfully!';
              document.body.appendChild(successMsg);

              // Remove modal
              modal.remove();

              // Reload page after a short delay
              setTimeout(() => {
                window.location.reload();
              }, 1000);
            } else {
              throw new Error('Update failed');
            }
          })
          .catch(error => {
            console.error('Error updating photo:', error);

            // Show error message
            const errorMsg = document.createElement('div');
            errorMsg.className = 'alert alert-error';
            errorMsg.style.position = 'fixed';
            errorMsg.style.top = '20px';
            errorMsg.style.right = '20px';
            errorMsg.style.zIndex = '10000';
            errorMsg.innerHTML = '❌ Failed to update photo. Please try again.';
            document.body.appendChild(errorMsg);

            // Reset button
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;

            // Remove error message after 3 seconds
            setTimeout(() => {
              errorMsg.remove();
            }, 3000);
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

      // Set title
      title.textContent = photo.caption || 'Store Photos';

      // Set meta information
      let metaHTML = `
        <div class="post-detail-meta-item">
            <span class="post-detail-meta-label">📅 Upload Date</span>
            <span class="post-detail-meta-value">${photo.created_at}</span>
        </div>
        <div class="post-detail-meta-item">
            <span class="post-detail-meta-label">⭐ Featured Photos</span>
            <span class="post-detail-meta-value">${photo.featured_count} featured</span>
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
      const photoCount = 1;
      let gridClass = 'single';
      if (photoCount === 2) gridClass = 'two';
      else if (photoCount === 3) gridClass = 'three';
      else if (photoCount >= 4) gridClass = 'four-plus';

      imageGrid.className = `post-detail-image-grid ${gridClass}`;
      imageGrid.innerHTML = '';

    //   photo.photos.slice(0, photoCount === 3 ? 3 : photoCount > 4 ? 4 : photoCount).forEach((photo, index) => {
    //     const imageDiv = document.createElement('div');
    //     imageDiv.className = `post-detail-image-item ${photoCount === 3 && index === 0 ? 'large' : ''}`;

    //     imageDiv.innerHTML = `
    //         <img src="${photo.url}" alt="${photo.caption || 'Store photo'}" onclick="viewPhoto('${photo.url}', event)">
    //         ${photoCount > 4 && index === 3 ? `<div class="post-detail-more-images">+${photoCount - 4}</div>` : ''}
    //     `;

    //     imageGrid.appendChild(imageDiv);
    //   });

      // Set caption
      if (photo.caption) {
        captionContent.textContent = photo.caption;
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
