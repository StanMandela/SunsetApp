// Get the current hostname
const hostname = window.location.hostname;

// Set the base URL based on the hostname
let baseURL = "";

if (hostname === "localhost" || hostname === "127.0.0.1") {
  // Development environment
  baseURL = "http://localhost:8080";
} else if (hostname === "sunset.localhost") {
  // Production-like environment
  baseURL = "http://sunset.localhost";
}

new Vue({
  el: "#app",
  data: {
    sales: [],
    itemTypes: [],
    message: "Sales Page",
    selectedItemId: "",
    productName: "",
    productDesc: "",
    response: {
      status: null,
      message: '',
    }
  },
  mounted() {
    this.populateTable();
    this.populateItemTypes();
  },
  methods: {
    // Function to show the response div
    showResponseDiv(message) {
      var responseDiv = document.getElementById('responseDiv');
      var responseMessage = document.getElementById('responseMessage');

      // Update content and show the div
      responseMessage.innerHTML = message;
      responseDiv.style.display = 'block';

      // Optionally, you can set a timeout to hide the div after a certain period
      setTimeout(() => {
        this.hideResponseDiv();
      }, 5000); // Hides the div after 5000 milliseconds (5 seconds)
    },

    // Function to hide the response div
    hideResponseDiv() {
      var responseDiv = document.getElementById('responseDiv');
      responseDiv.style.display = 'none';
    },
    submitProduct() {
      // Prepare data to send to the API
      // Your Vue.js function
      const formData = new FormData();
      formData.append('item_type', this.selectedItemId);
      formData.append('product_name', this.productName);
      formData.append('description', this.productDesc);
     
      // Replace this URL with your actual API endpoint
      const apiUrl = baseURL + "/sales/add";

      // Using the fetch API to make a POST request
      fetch(apiUrl, {
        method: "POST",
        body:formData,
      
      })
        .then((response) => response.json())
        .then((responseData) => {
          // Handle the API response
          alert("API response: " + JSON.stringify(responseData));
          this.response.status = responseData.status;
          this.response.message = responseData.message;
          this.showResponseDiv(this.response.message);

        })
        .catch((error) => {
          // Handle errors
          this.response.status = '201';
          this.response.message = error.message;

        });
    },
    populateTable() {
      fetch(baseURL + "/sales")
        .then((response) => response.json())
        .then((data) => {
          // Update the products data
          this.sales = data;
          console.log('sales'.data);
        });

      //const tableBody = document.querySelector("#example tbody");

      // this.sales.forEach((sale, index) => {
      //   const row = document.createElement("tr");

      //   // Add other cells
      //   Object.values(sale).forEach((value) => {
      //     const cell = document.createElement("td");
      //     cell.textContent = value;
      //     row.appendChild(cell);
      //   });

      //   tableBody.appendChild(row);
      // });
    },
    populateItemTypes() {
      fetch(baseURL + "/itemtypes")
        .then((response) => response.json())
        .then((data) => {
          // Update the sales data
          this.itemTypes = data;
          console.log(data);
        });
    },
  },
});
