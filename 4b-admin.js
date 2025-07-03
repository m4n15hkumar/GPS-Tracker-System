document.addEventListener('DOMContentLoaded', function() {
    const admin = {
      delay: 10000, // Refresh every 10 seconds
      timer: null,
      wrapper: null,
      lastUpdate: null,
  
      init: function() {
        console.log('Admin panel initialized');
        this.wrapper = document.getElementById('wrapper');
        this.load();
        this.timer = setInterval(() => this.load(), this.delay);
      },
  
      load: function() {
        console.log('Fetching latest data...');
        const startTime = new Date();
        
        fetch('track-api.php', {
          method: 'POST',
          headers: { 
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'req=get'
        })
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('API Response:', data);
          this.lastUpdate = new Date();
          this.displayData(data);
        })
        .catch(error => {
          console.error('Error:', error);
          this.wrapper.innerHTML = `
            <div class="error-box">
              <p>Error loading data: ${error.message}</p>
              ${this.lastUpdate ? `<p>Last successful update: ${this.lastUpdate.toLocaleTimeString()}</p>` : ''}
              <button onclick="location.reload()">Retry</button>
            </div>
          `;
        });
      },
  
      displayData: function(data) {
        if (!data || !data.data || data.data.length === 0) {
          this.wrapper.innerHTML = '<p>No rider data available</p>';
          return;
        }
  
        let html = `
          <div class="header-row">
            <span>Rider</span>
            <span>Last Update</span>
            <span>Location</span>
          </div>
        `;
  
        data.data.forEach(location => {
          html += `
            <div class="rider-box">
              <div class="rider-info">
                <strong>${location.name || 'Unknown Rider'}</strong>
                <span>ID: ${location.rider_id || 'N/A'}</span>
              </div>
              <div class="time-info">
                ${location.timestamp ? new Date(location.timestamp).toLocaleString() : 'Unknown time'}
              </div>
              <div class="location-info">
                <span class="coordinates">
                  ${location.latitude?.toFixed(6) || '0'}, ${location.longitude?.toFixed(6) || '0'}
                </span>
              </div>
            </div>
          `;
        });
  
        html += `
          <div class="last-update">
            Last updated: ${new Date().toLocaleTimeString()}
            (${data.count} riders)
          </div>
        `;
  
        this.wrapper.innerHTML = html;
      }
    };
  
    admin.init();
  });