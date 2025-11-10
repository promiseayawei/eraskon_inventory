const mongoose = require('mongoose');

const productSchema = new mongoose.Schema({
  name: {
    type: String,
    required: true,
    trim: true
  },
  description: {
    type: String,
    trim: true
  },
  category: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'Category',
    required: true
  },
  sku: {
    type: String,
    required: true,
    unique: true,
    trim: true,
    validate: {
      validator: function(v) {
        return /^[A-Za-z0-9-_]{3,}$/.test(v);
      },
      message: props => `${props.value} is not a valid SKU! SKU must be at least 3 characters and contain only letters, numbers, hyphens and underscores.`
    }
  }
}, {
  timestamps: true
});

// Create index on SKU field
productSchema.index({ sku: 1 }, { unique: true });

module.exports = mongoose.model('Product', productSchema);