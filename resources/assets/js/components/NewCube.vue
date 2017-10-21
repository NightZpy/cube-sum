<template>
    <div v-if="!createValidCube">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h1>Generate new Matrix Cube</h1>
            </div>
        </div>
        <div class="form-group">
            <label for="nSize">N Dimention for the cube</label>
            <input v-bind:class="{ error: !isValidCube }"
                   @keyup.enter="makeCube"
                   v-model="nSize"
                   type="number"
                   class="form-control" id="nSize" name="nSize"
                   title="N Dimention for the cube"
                   placeholder="N Dimention for the cube">
        </div><!-- /input-group -->
    </div>
</template>

<script>
  export default {
    name: 'newcube',
    data () {
      return {
        nSize: 0,
        isValidCube: true,
        createValidCube: false
      }
    },
    methods: {
      makeCube () {
        if ( this.nSize > 1 ) {
          axios.post ('make-cube', {n: this.nSize})
          .then( response => {
            if (response.data.success) {
              this.createValidCube = this.isValidCube = true;
              this.$bus.$emit('cubeCreated', true);
            } else {
              this.isValidCube = false;
            }
          }).catch( e => {
            this.isValidCube = false;
            this.errors.push(e);
          });
        }
      }
    }
  };
</script>

<style scoped>
    input[type="number"]
    {
        font-size:24px;
        font-weight: bold;
    }

    .error {
        border: red solid 2px;
    }
</style>