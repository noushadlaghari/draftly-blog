    async function request(url, data) {
      try {
        const response = await fetch(url, {
          method: "POST",
          body: data
        });

        const raw = await response.text();

        if (!response.ok) {
          throw new Error(`HTTP ${response.status}`);
        }

        try {
          return JSON.parse(raw);
        } catch {
          return raw;
        }

      } catch (e) {
        console.error("Request Error:", e.message);
        return null;
      }
    }

  function showMessage(type, message) {
      let message_container = document.getElementById("message");
      message_container.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
          ${message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
      setTimeout(() => {
        message_container.innerHTML = "";
      }, 2500);
    }