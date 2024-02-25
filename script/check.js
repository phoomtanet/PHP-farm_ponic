function checkInput(elm) {
    if (!elm.value.match(/^[a-zA-Z0-9ก-๙ ]+$/i) && elm.value.length > 0  ) {
      alert('ไม่สามารถใช้ตัวอักษรพิเศษได้');
      elm.value = '';
      document.getElementById('ets_plot').innerHTML = '';
      } else if (elm.value.length > 10) {
        alert('ตัวอักษรไม่เกิน 10 ตัวอักษร');
        elm.value = '';
      document.getElementById('ets_plot').innerHTML = '';

    }
  }

  function checkInputTray(elm) {
    if (!elm.value.match(/^[a-zA-Z0-9 ]+$/i) && elm.value.length > 0  ) {
      alert('ไม่สามารถใช้ตัวอักษรพิเศษได้');
      elm.value = '';
      } else if (elm.value.length > 10) {
        alert('ตัวอักษรไม่เกิน 10 ตัวอักษร');
        elm.value = '';

    }
  }

  function checkInputUser(elm) {
    if (!elm.value.match(/^[a-zA-Z0-9 ]+$/i) && elm.value.length > 0  ) {
      alert('ไม่สามารถใช้ตัวอักษรพิเศษได้');
      elm.value = '';
      } else if (elm.value.length > 15) {
        alert('ตัวอักษรไม่เกิน 15 ตัวอักษร');
        elm.value = '';

    }
  }

  function checkInputName(elm) {
    if (!elm.value.match(/^[a-zA-Z0-9ก-๙ ]+$/i) && elm.value.length > 0  ) {
      alert('ไม่สามารถใช้ตัวอักษรพิเศษได้');
      elm.value = '';
      } else if (elm.value.length > 15) {
        alert('ตัวอักษรไม่เกิน 15 ตัวอักษร');
        elm.value = '';

    }
  }

  function checkInputvet(elm) {
    if (!elm.value.match(/^[a-zA-Z0-9ก-๙ ]+$/i) && elm.value.length > 0  ) {
      alert('ไม่สามารถใช้ตัวอักษรพิเศษได้');
      elm.value = '';
      } else if (elm.value.length > 20) {
        alert('ตัวอักษรไม่เกิน 20 ตัวอักษร');
        elm.value = '';

    }
  }

  function checkInt(elm) {
    if (!elm.value.match(/^[0-9]+$/i) && elm.value.length > 0) {
      alert('ไม่สามารถใช้ตัวอักษรพิเศษและภาษาไทยได้');
      elm.value = '';
      // } else if (elm.value.length > 0) {
      //   alert('Username ต้องมีมากกว่า 6 ตัวอักษร');
      //   elm.value = '';
    }
  }

  function checkInputtext(elm) {
    if (!elm.value.match(/^[a-zA-Z0-9ก-๙ ]+$/i) && elm.value.length > 0  ) {
      alert('ไม่สามารถใช้ตัวอักษรพิเศษได้');
      elm.value = '';
      } else if (elm.value.length > 30) {
        alert('ตัวอักษรไม่เกิน 30 ตัวอักษร');
        elm.value = '';

    }
  }