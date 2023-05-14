class Notification {
  timeout = 3000;

  _createNotification(title, text, classnames = []) {
    const body = document.createElement("div");

    body.classList.add("notification", classnames);

    const titleEl = document.createElement("h3");
    const textEl = document.createElement("p");

    titleEl.textContent = title;
    textEl.textContent = text;

    body.append(titleEl);
    body.append(textEl);

    return body;
  }

  _append(notification) {
    const container = document.getElementById("notifications");

    container.append(notification);

    return setTimeout(() => notification.remove(), this.timeout);
  }

  showError(title, text) {
    return this._append(this._createNotification(title, text, "error"));
  }

  showSuccess(title, text) {
    return this._append(this._createNotification(title, text, "success"));
  }
}

class ValuteConverter {
  template = "Convert {from} to {to}";

  constructor(container) {
    this.container = container;
    this.notification = new Notification();

    if (!this.container) {
      return false;
    }

    this._findElemenets();
    this.init();
  }

  _findElemenets() {
    this.button = this.container.querySelector(".js-convert-button");
    this.selectors = Array.from(this.container.querySelectorAll("select"));
    this.inputs = Array.from(this.container.querySelectorAll("input"));
  }

  _getSelectedOption(select) {
    return select.options[select.selectedIndex];
  }

  _setButtonText(text = this.template) {
    this.button.textContent = text;
  }

  _onChangeSelectValuteHandle() {
    this._setButtonText();

    this.selectors.forEach((select) => {
      this._setButtonText(
        this.button.textContent.replace(
          `{${select.dataset.attr}}`,
          this._getSelectedOption(select).value
        )
      );
    });
  }

  _createFormData() {
    const formData = new FormData();

    this.inputs.forEach((input) => {
      formData.append(input.name, input.value);
    });

    this.selectors.forEach((select) => {
      formData.append(select.name, this._getSelectedOption(select).value);
    });

    return formData;
  }

  async _onClickConvertButtonHandle() {
    const formData = this._createFormData();

    const { response, data } = await this.convert(formData);

    if (!response.ok) {
      this.notification.showError("Error", "Error in sending an HTTP request");

      return false;
    }

    if (!data.status) {
      this.notification.showError("Error", data.message);

      return false;
    }

    this.notification.showSuccess("Success!", data.message);

    this.inputs.forEach((input) => {
      input.value = data.data[input.name];
    });
  }

  async convert(body) {
    const response = await fetch(`${window.location.origin}/valutes/convert`, {
      method: "POST",
      body: body,
    });

    const data = await response.json();

    return { response, data };
  }

  init() {
    this._onChangeSelectValuteHandle();

    this.selectors.forEach((select) => {
      select.addEventListener(
        "change",
        this._onChangeSelectValuteHandle.bind(this)
      );
    });

    this.button.addEventListener(
      "click",
      this._onClickConvertButtonHandle.bind(this)
    );
  }
}

const DOMReady = (callback) => {
  if (document.readyState != "loading") callback();
  else document.addEventListener("DOMContentLoaded", callback);
};

DOMReady(() => {
  const showDetailsButton = document.querySelector(".js-show-details");

  if (showDetailsButton) {
    const detailElement = showDetailsButton.nextElementSibling;

    const onClickHandle = (e) => {
      e.preventDefault();

      detailElement.classList.toggle("active");
    };

    showDetailsButton.addEventListener("click", onClickHandle);
  }

  new ValuteConverter(document.getElementById("parser"));
});
