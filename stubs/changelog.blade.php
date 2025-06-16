<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Changelog</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
      background: #fafafa;
      color: #333;
      line-height: 1.6;
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
      padding: 2rem 1rem;
    }

    .header {
      margin-bottom: 2rem;
    }

    .header h1 {
      font-size: 2rem;
      color: #222;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    .header p {
      color: #666;
      margin-bottom: 1rem;
    }

    .filters {
      background: white;
      padding: 1rem;
      border-radius: 8px;
      border: 1px solid #e1e4e8;
      margin-bottom: 2rem;
    }

    .filters select {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #d1d5da;
      border-radius: 6px;
      font-size: 0.9rem;
      background: white;
    }

    .changelog-entry {
      background: white;
      border: 1px solid #e1e4e8;
      border-radius: 8px;
      margin-bottom: 1rem;
      overflow: hidden;
    }

    .entry-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem;
      border-bottom: 1px solid #e1e4e8;
      background: #f6f8fa;
    }

    .entry-date {
      color: #586069;
      font-size: 0.9rem;
    }

    .entry-meta {
      display: flex;
      gap: 0.5rem;
      align-items: center;
    }

    .version-number {
      font-size: 1.25rem;
      font-weight: 600;
      color: #24292e;
    }

    .type-badge {
      background: #28a745;
      color: white;
      padding: 0.25rem 0.5rem;
      border-radius: 12px;
      font-size: 0.75rem;
      font-weight: 500;
      text-transform: uppercase;
    }

    .type-new { background: #28a745; }
    .type-improvement { background: #0366d6; }
    .type-fix { background: #f66a0a; }
    .type-security { background: #d73a49; }
    .type-deprecated { background: #6f42c1; }

    .entry-content {
      padding: 1rem;
    }

    .entry-title {
      font-size: 1rem;
      font-weight: 600;
      color: #24292e;
      margin-bottom: 0.75rem;
    }

    .entry-description {
      color: #586069;
      line-height: 1.5;
    }

    .entry-description ul {
      margin-left: 1.25rem;
    }

    .entry-description li {
      margin-bottom: 0.25rem;
    }

    .entry-actions {
      padding: 0.75rem 1rem;
      border-top: 1px solid #e1e4e8;
      background: #f6f8fa;
      display: flex;
      justify-content: flex-end;
    }

    .share-btn {
      background: none;
      border: 1px solid #d1d5da;
      border-radius: 6px;
      padding: 0.5rem 0.75rem;
      color: #586069;
      cursor: pointer;
      font-size: 0.875rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.2s;
    }

    .share-btn:hover {
      background: #f3f4f6;
      border-color: #c6cbd1;
    }

    .share-btn:active {
      background: #edeff2;
    }

    .copy-icon {
      width: 14px;
      height: 14px;
    }

    .no-entries {
      text-align: center;
      padding: 3rem 1rem;
      color: #586069;
      background: white;
      border: 1px solid #e1e4e8;
      border-radius: 8px;
    }

    .toast {
      position: fixed;
      bottom: 1rem;
      right: 1rem;
      background: #28a745;
      color: white;
      padding: 0.75rem 1rem;
      border-radius: 6px;
      opacity: 0;
      transform: translateY(100%);
      transition: all 0.3s ease;
      z-index: 1000;
    }

    .toast.show {
      opacity: 1;
      transform: translateY(0);
    }

    @media (max-width: 768px) {
      .container { padding: 1rem 0.5rem; }
      .entry-header { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
      .entry-meta { flex-direction: column; align-items: flex-start; }
    }
  </style>
</head>
<body>
<div class="container">
  <div class="header">
    <h1>Changelog</h1>
    <p>Follow up on the latest improvements and updates.</p>
  </div>

  <div class="filters">
    <form method="GET">
      <select name="type" onchange="this.form.submit()">
        <option value="">All Types</option>
        @foreach($types as $type)
          <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
            {{ ucfirst($type) }}
          </option>
        @endforeach
      </select>
    </form>
  </div>

  <div class="changelog-list">
    @forelse($changelogs as $changelog)
      <div class="changelog-entry">
        <div class="entry-header">
          <div class="entry-date">
            {{ $changelog->release_date->format('F j, Y') }}
          </div>
          <div class="entry-meta">
            <div class="version-number">{{ $changelog->version }}</div>
            <span class="type-badge type-{{ $changelog->type }}">
                                {{ $changelog->type }}
                            </span>
          </div>
        </div>

        <div class="entry-content">
          <h3 class="entry-title">{{ $changelog->title }}</h3>

          @if($changelog->description)
            <div class="entry-description">
              {!! nl2br(e($changelog->description)) !!}
            </div>
          @endif
        </div>

        <div class="entry-actions">
          <button class="share-btn" onclick="copyToClipboard('{{ url()->current() }}#{{ $changelog->version }}')">
            <svg class="copy-icon" fill="currentColor" viewBox="0 0 20 20">
              <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
              <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
            </svg>
            Copy Link
          </button>
        </div>
      </div>
    @empty
      <div class="no-entries">
        <h3>No changelog entries found</h3>
        <p>No updates have been published yet.</p>
      </div>
    @endforelse
  </div>
</div>

<div id="toast" class="toast">
  Link copied to clipboard!
</div>

<script>
  function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
      showToast();
    });
  }

  function showToast() {
    const toast = document.getElementById('toast');
    toast.classList.add('show');

    setTimeout(() => {
      toast.classList.remove('show');
    }, 2000);
  }
</script>
</body>
</html>
