<template>
  <v-dialog v-model="dialog" max-width="800px">
    <template v-slot:activator="{ on }">
      <v-btn color="primary" dark class="mb-2" v-on="on" @click="newItem()">{{ $tc('ShiftMaster.Button.NewItem') }}</v-btn>
    </template>
    <v-card>
      <v-card-title>
        <span class="headline">{{ formTitle }}</span>
      </v-card-title>
      <v-form ref="form">
        <v-text-field v-model.trim="$v.formData.shiftmasterid" v-show="false" />
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                    v-model.trim="$v.formData.cleaningshiftcode.$model"
                    :label="$tc('ShiftMaster.DialogField.CleaningShiftCode')"
                    maxlength="3"
                    :disabled="disableCode"
                />
                <div class="error-message" v-if="$v.formData.cleaningshiftcode.$dirty && !$v.formData.cleaningshiftcode.required">{{ $tc("ShiftMaster.ErrorMessage.NotNull", 0) }}</div>
                <div class="error-message" v-if="$v.formData.cleaningshiftcode.$dirty && !$v.formData.cleaningshiftcode.alphaNum">{{ $tc("ShiftMaster.ErrorMessage.AlphaNum", 0) }}</div>
                <div class="error-message" v-if="$v.formData.cleaningshiftcode.$dirty && !$v.formData.cleaningshiftcode.checkDuplicate">{{ $tc("ShiftMaster.ErrorMessage.ShiftCodeDuplicate", 0) }}</div>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model.trim="$v.formData.name.$model"
                  :label="$tc('ShiftMaster.DialogField.Name')"
                  maxlength="30"
                />
                <div class="error-message" v-if="$v.formData.name.$dirty && !$v.formData.name.required">{{ $tc("ShiftMaster.ErrorMessage.NotNull", 0) }}</div>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model.trim="$v.formData.shortname.$model"
                  :label="$tc('ShiftMaster.DialogField.ShortName')"
                  maxlength="10"
                />
                <div class="error-message" v-if="$v.formData.shortname.$dirty && !$v.formData.shortname.required">{{ $tc("ShiftMaster.ErrorMessage.NotNull", 0) }}</div>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="$v.formData.shiftstarttime.$model"
                  @input="getWorkingTime"
                  hint="Please input [hhmm] format here."
                  :label="$tc('ShiftMaster.DialogField.ShiftStartTime')"
                  maxlength="4"
                />
                <div class="error-message" v-if="$v.formData.shiftstarttime.$dirty && !$v.formData.shiftstarttime.required">{{ $tc("ShiftMaster.ErrorMessage.NotNull", 0) }}</div>
                <div class="error-message" v-if="$v.formData.shiftstarttime.$dirty && !$v.formData.shiftstarttime.timeRule">{{ $tc("ShiftMaster.ErrorMessage.TimeRule", 0) }}</div>
                <div class="error-message" v-if="$v.formData.shiftstarttime.$dirty && !$v.formData.shiftstarttime.checkShiftBreakShiftStart">{{ $tc("ShiftMaster.ErrorMessage.CheckBreakStartTime", 0) }}</div>
                <div class="error-message" v-if="$v.formData.shiftstarttime.$dirty && !$v.formData.shiftstarttime.checkShiftTermStart">{{ $tc("ShiftMaster.ErrorMessage.CheckShiftTerm", 0) }}</div>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="$v.formData.shiftendtime.$model"
                  @input="getWorkingTime"
                  hint="Please input [hhmm] format here."
                  :label="$tc('ShiftMaster.DialogField.ShiftEndTime')"
                  maxlength="4"
                />
                <div class="error-message" v-if="$v.formData.shiftendtime.$dirty && !$v.formData.shiftendtime.required">{{ $tc("ShiftMaster.ErrorMessage.NotNull", 0) }}</div>
                <div class="error-message" v-if="$v.formData.shiftendtime.$dirty && !$v.formData.shiftendtime.timeRule">{{ $tc("ShiftMaster.ErrorMessage.TimeRule", 0) }}</div>
                <div class="error-message" v-if="$v.formData.shiftendtime.$dirty && !$v.formData.shiftendtime.checkShiftBreakShiftEnd">{{ $tc("ShiftMaster.ErrorMessage.CheckBreakEndTime", 0) }}</div>
                <div class="error-message" v-if="$v.formData.shiftendtime.$dirty && !$v.formData.shiftendtime.checkShiftTermEnd">{{ $tc("ShiftMaster.ErrorMessage.CheckShiftTerm", 0) }}</div>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="$v.formData.breakstarttime.$model"
                  @input="getWorkingTime"
                  hint="Please input [hhmm] format here."
                  :label="$tc('ShiftMaster.DialogField.BreakStartTime')"
                  maxlength="4"
                />
                <div class="error-message" v-if="$v.formData.breakstarttime.$dirty && !$v.formData.breakstarttime.timeRule">{{ $tc("ShiftMaster.ErrorMessage.TimeRule", 0) }}</div>
                <div class="error-message" v-if="$v.formData.breakstarttime.$dirty && !$v.formData.breakstarttime.checkShiftBreakBreakStart">{{ $tc("ShiftMaster.ErrorMessage.CheckBreakStartTime", 0) }}</div>
                <div class="error-message" v-if="$v.formData.breakstarttime.$dirty && !$v.formData.breakstarttime.checkBreakTermStart">{{ $tc("ShiftMaster.ErrorMessage.CheckBreakTerm", 0) }}</div>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="$v.formData.breakendtime.$model"
                  @input="getWorkingTime"
                  hint="Please input [hhmm] format here."
                  :label="$tc('ShiftMaster.DialogField.BreakEndTime')"
                  maxlength="4"
                />
                <div class="error-message" v-if="$v.formData.breakendtime.$dirty && !$v.formData.breakendtime.timeRule">{{ $tc("ShiftMaster.ErrorMessage.TimeRule", 0) }}</div>
                <div class="error-message" v-if="$v.formData.breakendtime.$dirty && !$v.formData.breakendtime.checkShiftBreakBreakEnd">{{ $tc("ShiftMaster.ErrorMessage.CheckBreakEndTime", 0) }}</div>
                <div class="error-message" v-if="$v.formData.breakendtime.$dirty && !$v.formData.breakendtime.checkBreakTermEnd">{{ $tc("ShiftMaster.ErrorMessage.CheckBreakTerm", 0) }}</div>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="$v.formData.description.$model"
                  :label="$tc('ShiftMaster.DialogField.Description')"
                  maxlength="200"
                />
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="$v.formData.sequence.$model"
                  :label="$tc('ShiftMaster.DialogField.Sequence')"
                  maxlength="3"
                  type="number"
                />
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  v-model="$v.formData.workingtime.$model"
                  :label="$tc('ShiftMaster.DialogField.WorkTime')"
                  :readonly="true"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
      </v-form>
      <v-card-actions>
        <v-spacer />
        <v-btn
          color="blue darken-1"
          text
          @click="close"
        >{{ $tc('ShiftMaster.Button.DialogCancelButton') }}</v-btn>
        <v-btn
          color="blue darken-1"
          text
          @click="save"
          :disabled="$v.$invalid"
        >{{ $tc('ShiftMaster.Button.DialogSaveButton') }}</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { required, minLength, maxLength, between, alpha, alphaNum, integer, helpers } from "vuelidate/lib/validators";
import Form from "@/js/utils/Form";
import i18n from "@/js/i18n";
// import { timeRule } from "@/js/validate/index.js";

const timeRule = (value) => value === '' || /^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(value);
const checkShiftBreakShiftStart = (value, vm) => !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(value) || !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(vm.breakstarttime) || value < vm.breakstarttime;
const checkShiftBreakShiftEnd = (value, vm) => !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(value) || !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(vm.breakendtime) || value > vm.breakendtime;
const checkShiftBreakBreakStart = (value, vm) => !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(value) || !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(vm.shiftstarttime) || value > vm.shiftstarttime;
const checkShiftBreakBreakEnd = (value, vm) => !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(value) || !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(vm.shiftendtime) || value < vm.shiftendtime;
const checkShiftTermStart = (value, vm) => !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(value) || !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(vm.shiftendtime) || value < vm.shiftendtime;
const checkShiftTermEnd = (value, vm) => !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(value) || !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(vm.shiftstarttime) || value > vm.shiftstarttime;
const checkBreakTermStart = (value, vm) => !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(value) || !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(vm.breakendtime) || value < vm.breakendtime;
const checkBreakTermEnd = (value, vm) => !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(value) || !/^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(vm.breakstarttime) || value > vm.breakstarttime;

export default {
  name: "Dialog",
  components: {},
  data() {
    return {
      formData: new Form({
        shiftmasterid: '',
        cleaningshiftcode: '',
        shiftstarttime: '',
        shiftendtime: '',
        breakstarttime: '',
        breakendtime: '',
        name: '',
        shortname: '',
        description: '',
        sequence: ''
      }),
      dialog: false,
      index: this.editedIndex,
    };
  },
  props: {
    editedIndex: {
      type: Number
    },
    list: {
      type: Array
    }
  },
  methods: {
    checkTime() {
      if (
        $v.formData.shiftstarttime >= $v.formData.breakstarttime &&
        $v.formData.breakstarttime != 0
      ) {
        return i18n.tc("ShiftMaster.ErrorMessage.CheckBreakStartTime", 0);
      } else if (
        $v.formData.shiftendtime <= $v.formData.breakendtime &&
        $v.formData.breakstarttime != 0
      ) {
        return i18n.tc("ShiftMaster.ErrorMessage.CheckBreakEndTime", 0);
      } else if (
        $v.formData.breakstarttime > $v.formData.breakendtime
      ) {
        return i18n.tc("ShiftMaster.ErrorMessage.CheckBreakTerm", 0);
      } else if (
        $v.formData.shiftstarttime > $v.formData.shiftendtime
      ) {
        return i18n.tc("ShiftMaster.ErrorMessage.CheckShiftTerm", 0);
      } else {
        return true;
      }
    },
    editItem(data) {
      this.formData.shiftmasterid = data.shiftmasterid;
      this.formData.cleaningshiftcode = data.cleaningshiftcode;
      this.formData.shiftstarttime = data.shiftstarttime;
      this.formData.shiftendtime = data.shiftendtime;
      this.formData.breakstarttime = data.breakstarttime;
      this.formData.breakendtime = data.breakendtime;
      this.formData.name = data.name;
      this.formData.shortname = data.shortname;
      this.formData.description = data.description;
      this.formData.sequence = data.sequence;
      this.index = this.editedIndex;
      this.getWorkingTime();
      this.dialog = true;
    },
    close() {
        this.$refs.form.reset();
        this.$v.$reset();
        this.dialog = false;
    },
    save() {
      if (this.index > -1) {
        const data = {
          url: "master/shifts/" + this.formData.shiftmasterid,
          data: this.formData.jsonData()
        };
        this.$store
          .dispatch("request/put", data)
          .then(() => {
            this.$store.dispatch("snackbar/success", { 
              type: "update " 
            });
            this.$emit('getList', false);
          })
          .catch(err => {
            this.$store.dispatch("snackbar/error", {
              type: "update ",
              result: err.result
            });
          });
      } else {
        const data = {
          url: "master/shifts",
          data: this.formData.jsonData()
        };
        this.$store
          .dispatch("request/post", data)
          .then(() => {
            this.$store.dispatch("snackbar/success", {
              type: "シフトマスタ作成"
            });
            this.$emit('getList', false);
          })
          .catch(err => {
            this.$store.dispatch("snackbar/error", {
              type: "シフトマスタ作成",
              result: err.result
            });
          });
      }
      this.close();
    },
    convertToMinute(value) {
      value = String(value);
      if (value.length > 1) {
        return (
          parseInt(value.substring(0, 2)) * 60 + parseInt(value.substring(2))
        );
      } else return 0;
    },
    convertToHour(value) {
      if (value > 0) {
        var hours = parseInt(value / 60);
        var minutes = parseInt(value - hours * 60);
        if (hours < 10) {
          hours = "0" + hours;
        }
        if (minutes < 10) {
          minutes = "0" + minutes;
        }
        return hours + minutes;
      }
      return "0000";
    },
    getWorkingTime() {
      let term = this.convertToMinute(this.formData.shiftendtime) -
          this.convertToMinute(this.formData.shiftstarttime);
      if (this.formData.breakstarttime && this.formData.breakendtime) {
        term = term - 
          (this.convertToMinute(this.formData.breakendtime) -
            this.convertToMinute(this.formData.breakstarttime));
      }
      this.formData.workingtime = this.convertToHour(term);
    },
    newItem() {
      this.index = -1;
    },
  },
  computed: {
    formTitle() {
      let title = "";
      if (this.index === -1) {
        title = this.$i18n.tc("ShiftMaster.DialogTitle.NewItem");
      } else {
        title = this.$i18n.tc("ShiftMaster.DialogTitle.EditItem");
      }
      return title;
    },
    disableCode() {
      return this.index === -1 ? false : true;
    }
  },
  watch: {
  },
  validations: {
    formData: {
      cleaningshiftcode: {
        required,
        alphaNum,
        checkDuplicate(v) {
          if (this.index === -1) {
            for (var i of this.list) {
              if (v.trim() === i.cleaningshiftcode) {
                return false;
              }
            }
          }
          return true;
        },
      },
      name: {
        required,
      },
      shortname: {
        required,
      },
      shiftstarttime: {
        required,
        timeRule,
        checkShiftBreakShiftStart,
        checkShiftTermStart,
      },
      shiftendtime: {
        required,
        timeRule,
        checkShiftBreakShiftEnd,
        checkShiftTermEnd,
      },
      breakstarttime: {
        timeRule,
        checkShiftBreakBreakStart,
        checkBreakTermStart,
      },
      breakendtime: {
        timeRule,
        checkShiftBreakBreakEnd,
        checkBreakTermEnd,
      },
      description: {
      },
      sequence: {
      },
      workingtime: {
      },
    }
  },
};
</script>
