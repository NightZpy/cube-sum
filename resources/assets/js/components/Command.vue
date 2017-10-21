<template xmlns="http://www.w3.org/1999/html">
    <div v-if="isValidCube">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h1>Commands</h1></div>
            </div>
            <div class="panel panel-body">
                <div class="form-group">
                    <input v-bind:class="{ error: isInvalid }" @keyup.enter="sendCommand" v-model="operation"
                           type="text"
                           class="form-control" id="operation" name="operation"
                           placeholder="INSERT OPERATION HERE. Press [Enter] for send!">
                </div><!-- /input-group -->
            </div>
        </div>
        <div class="row" v-if="querys.length">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h2>Operation list</h2></div>
            </div>
            <div class="panel panel-body scroll">
                <ul>
                    <li v-for="q in querys">
                        <h3>
                            {{ q.type }} | {{ q.operation }} | <span v-if="q.total">Total: <em>{{ q.total }}</em></span>
                        </h3>
                    </li>
                </ul>
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
                    let query = {operation: this.operation, 'type': type};

                    if ( type == 'query')
                      query['total'] = response.data.total;
                    this.querys.push(query);
                    this.operation = '';
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
        font-size:14px;
        font-weight: bold;
    }

    .error {
        border: red solid 2px;
    }

    .scroll {
        height: 250px;
        overflow-y: auto;
    }
</style>
