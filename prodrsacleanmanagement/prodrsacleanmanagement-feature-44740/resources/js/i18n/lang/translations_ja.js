export default {
    ja: {
      ShiftMaster: {
        Button: {
          NewItem: '新規登録',
          DialogSaveButton: '保存',
          DialogCancelButton: 'キャンセル',
        },
        DialogTitle: {
          NewItem: '新規登録',
          EditItem: '変更',
        },
        ListColumn: {
          CleaningShiftCode: 'シフトコード',
          Name: '名称',
          ShiftStartTime: '勤務開始時刻',
          ShiftEndTime: '勤務終了時刻',
          BreakStartTime: '休憩開始時刻',
          BreakEndTime: '休憩終了時刻',
          Action: '操作',
        },
        DialogField: {
          CleaningShiftCode: 'シフトコード',
          Name: '名称',
          ShortName: '略称',
          ShiftStartTime: '勤務開始時刻',
          ShiftEndTime: '勤務終了時刻',
          BreakStartTime: '休憩開始時刻',
          BreakEndTime: '休憩終了時刻',
          Description: '備考',
          Sequence: '表示順序',
          WorkTime: '労働時間',
        },
        ErrorMessage: {
          TimeRule: '時間は hhmm の書式で入力してください。',
          NotNull: 'この項目は必須入力です。',
          AlphaNum: 'このフィールドには英数字を入力してください。',
          CheckShiftTerm: '勤務開始時刻は勤務終了時刻より前の時刻を入力してください。',
          CheckBreakTerm: '休憩開始時刻は休憩終了時刻より前の時刻を入力してください。',
          CheckBreakStartTime: '休憩開始時刻が不正です。勤務開始時刻より後の時刻を入力してください。',
          CheckBreakEndTime: '休憩終了時刻が不正です。勤務終了時刻より前の時刻を入力してください。',
          ShiftCodeDuplicate: 'シフトコードが重複しています。重複しないコードを入力してください。',
        },
      }
    }
  }
