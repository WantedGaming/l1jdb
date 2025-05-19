// Error monitor for admin users
const ErrorMonitor = {
    container: null,
    lastTimestamp: 0,
    checkInterval: 10000, // Check every 10 seconds
    isMinimized: false,
    timer: null,
    
    init: function() {
        // Create container if it doesn't exist
        if (!this.container) {
            this.createUI();
        }
        
        // Start polling
        this.startPolling();
        
        // Initial fetch
        this.fetchErrors();
    },
    
    createUI: function() {
        // Create container
        this.container = document.createElement('div');
        this.container.id = 'error-monitor';
        this.container.className = 'error-monitor';
        
        // Create header
        const header = document.createElement('div');
        header.className = 'error-monitor-header';
        
        // Create title
        const title = document.createElement('div');
        title.className = 'error-monitor-title';
        title.textContent = 'Error Log Monitor';
        
        // Create actions
        const actions = document.createElement('div');
        actions.className = 'error-monitor-actions';
        
        // Create minimize button
        const minimizeBtn = document.createElement('button');
        minimizeBtn.className = 'error-monitor-btn error-monitor-minimize';
        minimizeBtn.innerHTML = '&minus;';
        minimizeBtn.title = 'Minimize';
        minimizeBtn.addEventListener('click', () => this.toggleMinimize());
        
        // Create close button
        const closeBtn = document.createElement('button');
        closeBtn.className = 'error-monitor-btn error-monitor-close';
        closeBtn.innerHTML = '&times;';
        closeBtn.title = 'Close';
        closeBtn.addEventListener('click', () => this.close());
        
        // Add buttons to actions
        actions.appendChild(minimizeBtn);
        actions.appendChild(closeBtn);
        
        // Add title and actions to header
        header.appendChild(title);
        header.appendChild(actions);
        
        // Create content
        const content = document.createElement('div');
        content.className = 'error-monitor-content';
        
        // Create log list
        const logList = document.createElement('ul');
        logList.className = 'error-monitor-logs';
        
        // Add log list to content
        content.appendChild(logList);
        
        // Add header and content to container
        this.container.appendChild(header);
        this.container.appendChild(content);
        
        // Add container to body
        document.body.appendChild(this.container);
        
        // Add styles
        this.addStyles();
    },
    
    addStyles: function() {
        const style = document.createElement('style');
        style.textContent = `
            .error-monitor {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 400px;
                max-height: 300px;
                background-color: #1a1a1a;
                border: 1px solid #f94b1f;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
                font-family: monospace;
                z-index: 9999;
                transition: all 0.3s ease;
                display: flex;
                flex-direction: column;
            }
            
            .error-monitor.minimized {
                max-height: 40px;
                overflow: hidden;
            }
            
            .error-monitor-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 12px;
                background-color: #111111;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 8px 8px 0 0;
            }
            
            .error-monitor-title {
                color: #f94b1f;
                font-weight: bold;
            }
            
            .error-monitor-actions {
                display: flex;
                gap: 8px;
            }
            
            .error-monitor-btn {
                background: transparent;
                border: none;
                color: rgba(255, 255, 255, 0.7);
                cursor: pointer;
                width: 24px;
                height: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 4px;
                font-size: 16px;
            }
            
            .error-monitor-btn:hover {
                background-color: rgba(255, 255, 255, 0.1);
                color: white;
            }
            
            .error-monitor-content {
                padding: 12px;
                overflow-y: auto;
                max-height: 250px;
            }
            
            .error-monitor-logs {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            
            .error-monitor-logs li {
                margin-bottom: 8px;
                padding: 8px;
                background-color: rgba(255, 255, 255, 0.05);
                border-radius: 4px;
                color: #ddd;
                word-break: break-word;
                font-size: 12px;
                position: relative;
                padding-left: 20px;
                line-height: 1.4;
            }
            
            .error-monitor-logs li::before {
                content: '⚠️';
                position: absolute;
                left: 4px;
                top: 8px;
                font-size: 10px;
                color: #f94b1f;
            }
            
            .error-monitor-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background-color: #dc3545;
                color: white;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                font-weight: bold;
            }
        `;
        document.head.appendChild(style);
    },
    
    toggleMinimize: function() {
        this.isMinimized = !this.isMinimized;
        
        if (this.isMinimized) {
            this.container.classList.add('minimized');
            const minimizeBtn = this.container.querySelector('.error-monitor-minimize');
            minimizeBtn.innerHTML = '+';
            minimizeBtn.title = 'Expand';
        } else {
            this.container.classList.remove('minimized');
            const minimizeBtn = this.container.querySelector('.error-monitor-minimize');
            minimizeBtn.innerHTML = '&minus;';
            minimizeBtn.title = 'Minimize';
        }
    },
    
    close: function() {
        // Stop polling
        this.stopPolling();
        
        // Remove container
        if (this.container && this.container.parentNode) {
            this.container.parentNode.removeChild(this.container);
            this.container = null;
        }
    },
    
    startPolling: function() {
        this.stopPolling(); // Clear any existing timer
        this.timer = setInterval(() => this.fetchErrors(), this.checkInterval);
    },
    
    stopPolling: function() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    },
    
    fetchErrors: function() {
        fetch(`/admin/error-logs.php?since=${this.lastTimestamp}`)
            .then(response => response.json())
            .then(data => {
                this.lastTimestamp = data.timestamp;
                this.updateLogs(data.logs);
            })
            .catch(error => console.error('Error fetching logs:', error));
    },
    
    updateLogs: function(logs) {
        if (!this.container) return;
        
        const logList = this.container.querySelector('.error-monitor-logs');
        if (!logList) return;
        
        // Add new logs
        if (logs.length > 0) {
            // Clear existing logs
            logList.innerHTML = '';
            
            // Add new logs
            logs.forEach(log => {
                const li = document.createElement('li');
                li.textContent = log;
                logList.appendChild(li);
            });
            
            // Show the monitor if minimized and we have new logs
            if (this.isMinimized && logs.length > 0) {
                // Add badge showing count
                let badge = this.container.querySelector('.error-monitor-badge');
                
                if (!badge && logs.length > 0) {
                    badge = document.createElement('div');
                    badge.className = 'error-monitor-badge';
                    badge.textContent = logs.length;
                    this.container.querySelector('.error-monitor-header').appendChild(badge);
                } else if (badge) {
                    badge.textContent = logs.length;
                }
            } else if (!this.isMinimized) {
                // Remove badge if expanded
                const badge = this.container.querySelector('.error-monitor-badge');
                if (badge) {
                    badge.parentNode.removeChild(badge);
                }
            }
        }
    }
};

// Initialize if user is admin
document.addEventListener('DOMContentLoaded', function() {
    // Check if user is admin by looking for admin-specific elements
    const isAdmin = document.querySelector('.admin-header') !== null || 
                    document.querySelector('.admin-nav') !== null;
    
    if (isAdmin) {
        ErrorMonitor.init();
    }
});
