var myApp = new Vue({
  el: "#app",
  data() {
      return {
        message:"Helloe ",
          active_students: 0,
          active_teachers:0,
          courses_created: 0,
          active_courses: 0,
          students_posts: 0,
          teachers_posts: 0,
          calls_bar_chat_data: [],
          meetings_chart_data: [],
          axis_for_charts: [],
          axis_for_combined_chart:[]


      };
  },
  methods: {
      loadEvent() {
          let duration = document.getElementById("reportrange").value
          if(duration == ""){
              //catch error
              Swal.fire({
                  icon: 'error',
                  title: 'Date',
                  text: 'Select an option from the dropdown',
                  confirmButtonText: `Okay`,
              })

          }else{
              this.fetchData(duration)
          }
      },

  
      fetchData(period) {


          /*
          * 1. set preloader
          * 2. fetch api data
          * 3. Hide Preloader
          * 4. Prepare data
          * */

          // STEP 1 :Set Preloader
        //  document.getElementById('loading').style.display = "block"


          //STEP 2 : Fetch data

          let postData = {
              date:period
          }

          var base = document.getElementById("base").innerText
          this.$http.post(base + '/gsuite/gMail', postData)
              .then(response => {
                  console.log(response.json())

                  return response.json()
                 

              },
              (reason)=>{
                  return false
              })
              .then(data => {
                  //Step 3 : hide preloader
                  document.getElementById('loading').style.display = "none"

                  if(data.status =="true"){
                  data = data.value
                  
                  //empty the array
                  // this.calls_bar_chat_data = []
                  // this.meetings_chart_data= []
                  // this.team_chat_messages = []
                  // this.private_chat_messages= []
                  // this.axis_for_charts=[]

                  //Step 4 : prepare data
                  for (let index = 0; index < data.length; index++) {
                      this.num_emails_exchanged += data[index].num_emails_exchanged
                      this.pop_users += data[index].pop_users
                      this.emails_sent += data[index].num_emails_sent
                      this.num_outbound_rejected_emails += data[index].num_outbound_rejected_emails
                      this.num_inbound_rejected_emails += data[index].num_inbound_rejected_emails
                      this.avg_meeting_mins += data[index].meet_average_meeting_minutes
                      this.active_users += data[index].active_users
                     
                   

                      //TODO
                     this.calls_bar_chat_data.push(data[index].meet_num_calls)
                     this.meetings_chart_data.push(data[index].meet_num_calls)
                     this.team_chat_messages.push(data[index].meetingsOrganized)
                     this.private_chat_messages.push(data[index].privateChatMessages)
                     this.axis_for_charts.push(data[index].date)


                  }
              //Step 5: Populating the Charts
                
              //  this.callsBarChat()
              // this.meetingsBarChart()
              //this.preparaChartData()
                  
              // this.privateChatsChart()
              // this.teamsChatChart()
              }

             },

              );


      },
      preparaChartData(){
          console.log("Kwani hatufiki")
          //prepare data
          this.calls_bar_chat_data.push(this.meet_num_calls,this.meet_num_calls_web,this.meet_num_calls_internal_users,this.meet_num_calls_external_users)
          //prepare x-axis
          console.log(this.calls_bar_chat_data)

          this.axis_for_combined_chart.push('Number of calls','Web Calls','Internal Calls','External Calls')
          
          this.callsBarChat()
          

      },
      callsBarChat() {
          console.log('tumefika')
          ApexCharts.exec('gSuitecallsBarChart', 'updateSeries', [
              {
                   data: this.calls_bar_chat_data
              },

          ], true);
          ApexCharts.exec('gSuitecallsBarChart', 'updateOptions', {
              xaxis: {
                  categories: this.axis_for_combined_chart
              }
          }, false, true);


      },
      meetingsBarChart() {
          console.log('tumefika Meeting')

          console.log(this.meetings_chart_data)
          console.log(this.axis_for_charts)
          ApexCharts.exec('gSuiteMeetingsBarChart', 'updateSeries', [
              {
                   data: this.meetings_chart_data
              },

          ], true);
          ApexCharts.exec('gSuiteMeetingsBarChart', 'updateOptions', {
              xaxis: {
                  categories: this.axis_for_charts
              }
          }, false, true);


      },

  },
  mounted() {

      document.onreadystatechange = () => {
          if (document.readyState === "complete") {
              // run code here
              //this.ini()
             this.fetchData('initial')
          }
      }


  }

});