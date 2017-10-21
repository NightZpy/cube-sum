<template>
    <div v-if="isValidCube">
        <div class="panel panel-default">
            <div class="panel-heading text-center"><h1>Commands</h1></div>
        </div>
        <div class="panel panel-body">
            <div class="input-group">
                <!--<span class="input-group-addon">-->
                    <!--<input type="radio" v-model="type" name="type" value="update" selected> UPDATE-->
                    <!--<input type="radio" v-model="type" name="type" value="query"> QUERY-->
                <!--</span>-->
                <input v-bind:class="{ error: isInvalid }" @keyup.enter="sendCommand" v-model="operation" type="text"
                       class="form-control" id="operation" name="operation"
                       placeholder="INSERT OPERATION HERE. Press [Enter] for send!">
            </div><!-- /input-group -->

            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <ul>
                        <li v-for="q in querys">
                            <em>{{ q.operation }}: </em>
                            <strong>{{ q.total }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
          return {
            //type: '',
            operation: '',
            isInvalid: false,
            querys: [],
            isValidCube: false
          }
        },
        mounted() {
          this.$bus.$on('cubeCreated', (info) => {
            this.isValidCube = true;
          })
        },
        methods: {
          sendCommand () {

            this.isInvalid = false;
            //if (this.type == 'query')
            let type = '';
            if ( /^\d+( ?\d+){5}$/.test(this.operation) )
              type = 'query';
            else if ( /^\d+( ?\d+){3}$/.test(this.operation) )
              type = 'update';
            else
              this.isInvalid = true;


            if ( !this.isInvalid ) {
                console.log(type);
                let data = { cube_id: 1, operation: this.operation };
                  axios.post(type, data)
                  .then(response => {
                    let query = {operation: this.operation};

                    if ( type == 'query') {
                      console.log('agregando total');
                      query['total'] = response.data.total;
                    }

                    console.log('query');
                    console.log(query);
                    this.querys.push(query);
                    console.log(querys);
                  })
                  .catch(e => {
                    //this.errors.push(e)
                  });
            }
          }
        }
    }
</script>

<style scoped>
    input[type="text"]
    {
        font-size:24px;
        font-weight: bold;
    }

    .error {
        border: red solid 2px;
    }
</style>
