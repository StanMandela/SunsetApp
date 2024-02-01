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
    stockModalData: null,
    modalData: null,
    productsItems: [],
    productsDropDown:[],
    products: [],
    stockValue: [],
    message: "Stock Page",
    selectedProductId: "",
    stock: "",
    files: [],
    response: {
      status: null,
      message: "",
    },
  },
  mounted() {
    this.populateTable();
    this.populateProductDropDown();
    this.populateStockValue();
  },
  methods: {
    handleFileChange(event) {
      this.files = event.target.files;
    },
    editItem(product) {
      $("#editModal").modal("show");
      //console.log(price.product_id)
      // Set modalData with the data from the clicked row
      this.modalData = {
        product_name: product.product_name,
        current_stock: product.quantity,
        product_id: product.product_id,
        new_stock: 0,

        // Additional properties as needed
      };
    },
    editStockValueModal(stock) {
      $("#editStockModal").modal("show");
      //console.log(price.product_id)
      // Set modalData with the data from the clicked row
      this.stockModalData = {
        lodging: stock.lodging,
        mpesa_balance: stock.mpesa_balance,
        purchases: stock.purchases,
        date: stock.updated_on,

        // Additional properties as needed
      };
    },
    closeModal() {
      // Close the modal by resetting modalData
      this.modalData = null;
    },
    calculateStock() {
      // Replace this URL with your actual API endpoint
      const apiUrl = baseURL + "/quantities/getStockValue";

      // Using the fetch API to make a POST request
      fetch(apiUrl, {
        method: "GET",
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
    editStockValues() {
      const formData = new FormData();

      formData.append("date", this.stockModalData.date);
      formData.append("lodging", this.stockModalData.lodging);
      formData.append("mpesa_balance", this.stockModalData.mpesa_balance);
      formData.append("purchases", this.stockModalData.purchases);
      // console.log(formData);

      // Replace this URL with your actual API endpoint
      const apiUrl = baseURL + "/quantities/ediStockValue";
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
    editProductStock() {
      const formData = new FormData();

      formData.append("product_id", this.modalData.product_id);
      formData.append("new_stock", this.modalData.new_stock);
      formData.append("product_name", this.modalData.product_name);

      //console.log(this.modalData.product_name);
      console.log(this.modalData.product_id);

      // Replace this URL with your actual API endpoint
      const apiUrl = baseURL + "/quantities/edit";

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
    uploadRecipt(){
      var file = document.getElementById("file");
        // Replace this URL with your actual API endpoint
        console.log(file);
        const apiUrl = baseURL + "/quantities/fileUpload";

        // Using the fetch API to make a POST request
        fetch(apiUrl, {
          method: "POST",
      
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
    submitProductStock() {
      // Prepare data to send to the API
      // Your Vue.js function
      const formData = new FormData();
      formData.append("quantity", this.stock);
      formData.append("product_id", this.selectedProductId);
      formData.append("action_type", "restock");

      // Replace this URL with your actual API endpoint
      const apiUrl = baseURL + "/quantities/add";

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
      fetch(baseURL + "/quantities")
        .then((response) => response.json())
        .then((data) => {
          // Update the products data
          this.productsItems = data;
        });
    },
    populateProductDropDown() {
      fetch(baseURL + "/products")
        .then((response) => response.json())
        .then((data) => {
          // Update the products data
          this.productsDropDown = data;
        });
    },
    populateStockValue() {
      fetch(baseURL + "/quantities/stockValue")
        .then((response) => response.json())
        .then((data) => {
          // Update the sales data
          this.stockValue = data;
          console.log(this.stockValue);
        });
    },
  },
});
