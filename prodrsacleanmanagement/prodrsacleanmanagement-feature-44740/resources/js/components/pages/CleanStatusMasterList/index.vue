<template>
  <div>
    <section class="content-header">
      <h1>{{ this.$route.meta.title }}</h1>
    </section>
    <div>
      <template>
        <v-data-table
          :headers="headers"
          :items="desserts"
          sort-by="CleanStatusMasterList"
          class="elevation-1"
        >
      <template v-slot:top>
        <v-toolbar flat color="white">
          <v-toolbar-title>My CRUD</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2" v-on="on">New Item</v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-mask="'#####'" :counter= 5 v-model="editedItem.codestatus" label="Code tình trạng VS"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field :counter= 15 v-model="editedItem.namestatus" label="Tên tình trạng VS"></v-text-field>
                    </v-col>
            
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
    </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            small
            class="mr-2"
            @click="editItem(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            small
            @click="deleteItem(item)"
          >
            mdi-delete
        </v-icon>
      </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize">Reset</v-btn>
    </template>
        </v-data-table>
      </template>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue';
  import VueTheMask from 'vue-the-mask'
  Vue.use(VueTheMask)
  import {TheMask} from 'vue-the-mask'
  import {mask} from 'vue-the-mask'
  export default {
    name: "CleanStatusMasterList",
    components: {TheMask},
    directives: {mask},
    data() {
        return {
          dialog:false,
          headers:[
            {text:'Code tình trạng VS', value:'codestatus'},
            {text:'Tên tình trạng VS', value:'namestatus'},
            {text: 'Actions', value: 'actions', sortable: false },
          ],
          desserts: [],
          editedIndex: -1,
          editedItem: {
            codestatus:'',
            namestatus:''
          },
          defaultItem: {
            codestatus:'',
            namestatus:''
          },

        };
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
      },
    },
    props: {},
    mounted () {
    },
    watch: {
      dialog (val) {
        val || this.close()
      },
    },
    created () {
      this.initialize()
    },
    methods: {
      initialize () {
        this.desserts = [
          {
            codestatus: 'TODO',
            namestatus: 'chua',
          },
        ]
      },
      editItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },
      deleteItem (item) {
        const index = this.desserts.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
      },
      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },
      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.desserts[this.editedIndex], this.editedItem)
        } else {
          this.desserts.push(this.editedItem)
        }
        this.close()
      },
    },

    
};
</script>
