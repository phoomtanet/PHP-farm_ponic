function checkInput(elm) {
    if (!elm.value.match(/^[a-zA-Z0-9]+$/i) && elm.value.length > 0  ) {
      alert('ไม่สามารถใช้ตัวอักษรพิเศษและภาษาไทยได้');
      elm.value = '';
      document.getElementById('ets_plot').innerHTML = '';
      } else if (elm.value.length > 10) {
        alert('ตัวอักษรไม่เกิน 10 ตัวอักษร');
        elm.value = '';
      document.getElementById('ets_plot').innerHTML = '';

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