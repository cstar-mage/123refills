IBMBuilderStorage = {

    storage: {},
    
    blockData: {},

    //-------------------------------------------

    setStorageData: function(key, value) {
        this.storage[key] = value;
    },

    getStorageData: function (key) {
        return this.storage[key];
    },

    //-------------------------------------------

    setBlockData: function(blockId, data) {
        this.blockData[blockId] = data;
    },

    getBlockData: function(blockId) {
        return typeof this.blockData[blockId] == 'undefined' ? undefined : this.blockData[blockId];
    },

    getGroups: function(blockId) {
        if (typeof this.getBlockData(blockId) == 'undefined') {
            return undefined;
        }

        var blockData = this.getBlockData(blockId);

        return typeof blockData['groups'] == 'undefined' ? undefined : blockData['groups'];
    },

    getControls: function(blockId) {
        if (typeof this.getBlockData(blockId) == 'undefined') {
            return undefined;
        }

        var blockData = this.getBlockData(blockId);

        return typeof blockData['controls'] == 'undefined' ? undefined : blockData['controls'];
    },
    
    getIbmIdControls: function(blockId, ibmId) {
        if (typeof this.getControls(blockId) == 'undefined') {
            return undefined;
        }
        
        var controlsData = this.getControls(blockId);

        return typeof controlsData[ibmId] == 'undefined' ? undefined : controlsData[ibmId];
    },
    
    getControlDataByIndex: function(blockId, ibmId, index) {
        if (typeof this.getIbmIdControls(blockId, ibmId) == 'undefined') {
            return undefined;
        }
        
        var ibmIdControls = this.getIbmIdControls(blockId, ibmId);

        return typeof ibmIdControls[index] == 'undefined' ? undefined : ibmIdControls[index];
    }

    //-------------------------------------------
    
};