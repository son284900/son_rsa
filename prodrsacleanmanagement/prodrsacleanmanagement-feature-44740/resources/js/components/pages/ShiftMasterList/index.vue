/* eslint-disable no-unused-vars */
<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="this.list"
      :disable-pagination="true"
      :hide-default-footer="true"
      class="elevation-1"
      sort-by="editItem.sequence"
    >
      <template v-slot:top>
        <v-toolbar
          flat
          color="white"
        >
          <v-divider
            class="mx-4"
            inset
            vertical
          />
          <v-spacer />
          <Dialog
            ref="dialog"
            :editedIndex="editedIndex"
            :list="list"
          />
        </v-toolbar>
      </template>
      <template v-slot:item.action="{ item }">
        <v-icon
          small
          class="mr-2"
          @click="editItem(item)"
        >
          edit
        </v-icon>
        <v-icon
          small
          @click="deleteItem(item)"
        >
          delete
        </v-icon>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import {required} from 'vuelidate/lib/validators';
import Form from "@/js/utils/Form";
import i18n from '@/js/i18n';
import Dialog from '@/js/components/templates/Dialog';

export default {
    name: "ShiftMasterList",
    components: {
      Dialog,
    },
    data() {
        return {
            list: [],
            form: new Form({
                offset: 0,
                limit: 0,
                sort: '{"createtimestamp":"desc"}',
                q: "",
            }),
            dialog: false,
            editedIndex: -1,
            editedItem: {
                "cleaningshiftcode": '',
                "name": "",
                "shiftstarttime": "0000",
                "shiftendtime": "0000",
                "breakstarttime": "0000",
                "breakendtime": "0000",
                "workingtime": "0000"
            },
            defaultItem: {
                "cleaningshiftcode": '',
                "name": "",
                "shiftstarttime": "0000",
                "shiftendtime": "0000",
                "breakstarttime": "0000",
                "breakendtime": "0000",
                "workingtime": "0000"
            },
        };
    },
    props: {
    },
    mounted () {
        this.getList();
    },
    methods: {
        getList(haveMessage = true) {
            const url = 'master/shifts?' + this.form.requestParam();
            this.$store.dispatch('request/get', url)
                .then(res => {
                    this.list = res.result.data;
                    if (haveMessage === true){
                        this.$store.dispatch('snackbar/success', {type:'一覧取得'});
                    }
                })
                .catch(err => {
                    this.$store.dispatch('snackbar/error', {type:'一覧取得', result:err.result});
                });
        },
        editItem (item) {
            this.editedIndex = this.list.indexOf(item);
            const url = 'master/shifts/' + item.shiftmasterid;
            this.$store.dispatch('request/get', url)
                .then(res=>{
                    this.$refs.dialog.editItem(res.result.data);
                })
        },
        deleteItem (item) {
            const index = this.list.indexOf(item);
            const data = {
                url: 'master/shifts/',
                data: {
                    delete_ids: [item.shiftmasterid],
                    delete_type: 1,
                },
            }
            confirm('Are you sure you want to delete this item?') &&
                this.$store.dispatch('request/delete', data)
                    .then(() => {
                        this.list.splice(index,1);
                        this.$store.dispatch('snackbar/success', {type:'Delete'});
                    })
                    .catch(err => {
                        this.$store.dispatch('snackbar/error', {type:'Delete', result:err.result});
                    });
        },
    },
    computed: {
        headers () {
          return [
            {text: this.$i18n.tc('ShiftMaster.ListColumn.CleaningShiftCode'), value: 'cleaningshiftcode'},
            {text: this.$i18n.tc('ShiftMaster.ListColumn.Name'), value: 'name'},
            {text: this.$i18n.tc('ShiftMaster.ListColumn.ShiftStartTime'), value: 'shiftstarttime'},
            {text: this.$i18n.tc('ShiftMaster.ListColumn.ShiftEndTime'), value: 'shiftendtime'},
            {text: this.$i18n.tc('ShiftMaster.ListColumn.BreakStartTime'), value: 'breakstarttime'},
            {text: this.$i18n.tc('ShiftMaster.ListColumn.BreakEndTime'), value: 'breakendtime'},
            {text: this.$i18n.tc('ShiftMaster.ListColumn.Action'), value: 'action', sortable: false},
          ]
        },
    },
    watch: {
        dialog (val) {
            val || this.close()
        },
    },
};
</script>
