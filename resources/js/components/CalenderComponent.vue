<template>
  <div>

    <div id="form-modal">
      <create-component ref="form" @save="saveEvent"></create-component>
    </div>

    <v-menu bottom right>
      <template v-slot:activator="{ on }">
        <v-btn
          outlined
          color="grey darken-2"
          v-on="on"
        >
          <span>{{type}}</span>
        </v-btn>
      </template>

      <v-list>
        <v-list-item @click="type = 'day'">
          <v-list-item-title>Day</v-list-item-title>
        </v-list-item>
        <v-list-item @click="type = 'week'">
          <v-list-item-title>Week</v-list-item-title>
        </v-list-item>
        <v-list-item @click="type = 'month'">
          <v-list-item-title>Month</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>


    <v-sheet height="500">
      <v-calendar
          ref="calendar"
          locale="ja-jp"
          :type="type"
          :now="today"
          :value="today"
          :events="events"
          color="primary"
          @click:date="showDay"
          @click:day="createEvent"
      ></v-calendar>
    </v-sheet>
  </div>
</template>


<script>
  export default {
    data: () => ({
    today: `2020-05-19`,
    type:'month',
    datas:[],
    events: [
        {
          name: 'あたりまえ体操をする',
          start: '2020-05-18',
          end: '2020-05-1',
        },
        {
          name: 'Meeting',
          start: '2020-05-1 09:00',
          end: '2020-05-1 10:00',
        },
      ],
    }),
    computed:{
   
    },
    mounted () {

    },
    methods:{
      showDay({date}) {
        this.today = date;
        this.type = 'day';
      }
      createEvent({date}){
        this.$refs.form.open(date);
      }
      saveEvent(params){
        console.log("calendarcompoennt.xue");
        this.events.push(params);
        console.log(`保存しました。${params}`)
      }
    }
  }
</script>