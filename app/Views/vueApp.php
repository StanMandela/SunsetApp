<html>
  <body>
    <div id="app">
      <h1 sty>{{ message }}</h1>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    
    <script>
     var app = new Vue({
  el: '#app',
  data: {
    message: 'Hello Vue!'
  }
})
    </script>  
  </body>
</html>