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

        fetch('http://sunset.localhost/products')
                .then(response => response.json())
                .then(data => {
                    // Update the products data
                    this.products = data;
                    //console.log(this.products)
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                });
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