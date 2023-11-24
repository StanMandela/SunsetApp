// Get the current hostname
const hostname = window.location.hostname;

// Set the base URL based on the hostname
let baseURL = '';

if (hostname === 'localhost' || hostname === '127.0.0.1') {
  // Development environment
  baseURL = 'http://localhost:8080';
} else if (hostname === 'sunset.localhost') {
  // Production-like environment
  baseURL = 'http://sunset.localhost';
}

new Vue({
    el: '#app',
    data: {
      products: [],
      message:"Hello"
    },
    mounted() {
      this.populateTable();
    },
    methods: {
      populateTable() {

        fetch(baseURL+'/products')
                .then(response => response.json())
                .then(data => {
                    // Update the products data
                    this.products = data;
                    console.log(data)
                })
                
        const tableBody = document.querySelector('#example tbody');

        this.products.forEach((product, index) => {
          const row = document.createElement('tr');

         
          // Add other cells
          Object.values(product).forEach(value => {
            const cell = document.createElement('td');
            cell.textContent = value;
            row.appendChild(cell);
          });

          tableBody.appendChild(row);
        });
      }
    }
  });