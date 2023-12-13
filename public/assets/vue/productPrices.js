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
    modalData: null,
    prices: [],
    products: [],
    message: "Product Prices",
    selectedProductId: "",
    editedPrice: "",
    price: [],
    response: {
      status: null,
      message: "",
    },
  },
  mounted() {
    this.populateTable();
    this.populateProducts();
  },
  methods: {
    //openModal
    editItem(price) {
      $("#editModal").modal("show");
      //console.log(price.product_id)
      // Set modalData with the data from the clicked row
      this.modalData = {
        product_name: price.product_name,
        current_price: price.current_price,
        product_id: price.product_id,
        // Additional properties as needed
      };
    },
    closeModal() {
      // Close the modal by resetting modalData
      this.modalData = null;
    },
    // Function to show the response div
    showResponseDiv(message) {
      var responseDiv = document.getElementById("responseDiv");
      var responseMessage = document.getElementById("responseMessage");

      // Update content and show the div
      responseMessage.innerHTML = message;
      responseDiv.style.display = "block";

      // Optionally, you can set a timeout to hide the div after a certain period
      setTimeout(() => {
        this.hideResponseDiv();
      }, 5000); // Hides the div after 5000 milliseconds (5 seconds)
    },

    // Function to hide the response div
    hideResponseDiv() {
      var responseDiv = document.getElementById("responseDiv");
      responseDiv.style.display = "none";
    },
    editProductPrice() {
      const formData = new FormData();


      formData.append("product_id", this.modalData.product_id);
      formData.append("new_price", this.modalData.price);

      //console.log(this.modalData.product_name);
      console.log(this.modalData.price);

      // Replace this URL with your actual API endpoint
      const apiUrl = baseURL + "/prices/edit";

      // Using the fetch API to make a POST request
      fetch(apiUrl, {
        method: "POST",
        body: formData,
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
          this.response.status = "201";
          this.response.message = error.message;
        });
    },
    submitProductPrice() {
      // Prepare data to send to the API
      // Your Vue.js function
      const formData = new FormData();
      formData.append("product_id", this.selectedProductId);
      formData.append("price", this.price);
      console.log(this.selectedProductId);

      // Replace this URL with your actual API endpoint
      const apiUrl = baseURL + "/prices/add";

      // Using the fetch API to make a POST request
      fetch(apiUrl, {
        method: "POST",
        body: formData,
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
          this.response.status = "201";
          this.response.message = error.message;
        });
    },

    populateTable() {
      fetch(baseURL + "/prices")
        .then((response) => response.json())
        .then((data) => {
          // Update the products data
          this.prices = data;
          console.log("sales".data);
        });
    },
    populateProducts() {
      fetch(baseURL + "/products")
        .then((response) => response.json())
        .then((data) => {
          // Update the sales data
          this.products = data;
          console.log(data);
        });
    },
  },
});
