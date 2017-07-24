var IBMBuilderHistory = {

    data: [],

    limit: 50,

    cursor: null,

    setSnapshot: function (text) {

        if (this.data.length == 0) {
            this.data.push(text);
            this.cursor = 0;

            return;
        }

        var lastText = this.data[this.cursor];
        if (lastText == text) {
            return
        }

        this.data = this.data.slice(0, this.cursor + 1);

        this.data.push(text);

        if (this.data.length > this.limit) {
            this.data.shift();
        } else {
            this.cursor++;
        }
    },

    getSnapshot: function (index) {
        return this.data[index];
    },

    getUndo: function () {

        if (typeof this.data[this.cursor - 1] == 'undefined') {
            return null;
        }

        return this.getSnapshot(--this.cursor);
    },

    getRedo: function () {
        if (typeof this.data[this.cursor + 1] == 'undefined') {
            return null;
        }

        return this.getSnapshot(++this.cursor);
    }
}