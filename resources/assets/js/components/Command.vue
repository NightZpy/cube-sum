<template>
    <div>
        <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" v-model="type" name="type" value="update" selected> UPDATE
                <input type="radio" v-model="type" name="type" value="query"> QUERY
            </span>
            <input v-bind:class="{ error: isInvalid }" @keyup.enter="sendCommand" v-model="operation" type="text"
                   class="form-control" id="operation" name="operation"
                   placeholder="INSERT OPERATION HERE. Press [Enter] for send!">
        </div><!-- /input-group -->

        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <ul>
                    <li v-for="querys in query">
                        <em>{{ query.operation }}: </em>
                        <strong>{{ query.total }}</strong>
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
            type: '',
            operation: '',
            isInvalid: false,
            querys: []
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
          sendCommand () {

            this.isInvalid = false;
            if (this.type == 'query')
                if ( ! /^\d( ?\d){5}$/.test(this.operation) )
                  this.isInvalid = true;

            else
                if ( ! /^\d( ?\d){3}$/.test(this.operation) )
                  this.isInvalid = true;

            if ( !this.isInvalid ) {
                let data = { cube_id: 1, operation: this.operation };
                  axios.post(this.type, data)
                  .then(response => {
                    console.log(response.data);
                  })
                  .catch(e => {
                    this.errors.push(e)
                  })
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
