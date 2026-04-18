const Product = require('../models/Product');

// Helper function to generate SKU
const generateSKU = async (name) => {
  // Create base SKU from product name
  const baseSkuFromName = name
    .replace(/[^A-Za-z0-9]/g, '-') // Replace non-alphanumeric with hyphens
    .replace(/-+/g, '-') // Replace multiple hyphens with single
    .replace(/^-|-$/g, '') // Remove leading/trailing hyphens
    .toUpperCase()
    .slice(0, 20); // Limit length

  // Add timestamp and random suffix for uniqueness
  const timestamp = Date.now().toString(36);
  const randomSuffix = Math.random().toString(36).substring(2, 6).toUpperCase();
  const generatedSKU = `${baseSkuFromName}-${timestamp}${randomSuffix}`;

  // Verify uniqueness (recursive fallback)
  const existing = await Product.findOne({ sku: generatedSKU });
  if (existing) {
    return generateSKU(name); // Try again with new random values
  }

  return generatedSKU;
};

// Create a new product
exports.createProduct = async (req, res) => {
  try {
    // If SKU is not provided, generate one
    const sku = req.body.sku || await generateSKU(req.body.name);

    // Validate SKU format if provided
    if (req.body.sku && !/^[A-Za-z0-9-_]{3,}$/.test(req.body.sku)) {
      return res.status(400).json({ 
        message: "SKU must be at least 3 characters and contain only letters, numbers, hyphens and underscores" 
      });
    }

    // Check SKU uniqueness if provided
    if (req.body.sku) {
      const existingSku = await Product.findOne({ sku: req.body.sku });
      if (existingSku) {
        return res.status(400).json({ message: "SKU already exists" });
      }
    }

    const product = new Product({
      name: req.body.name,
      description: req.body.description,
      category: req.body.category,
      sku: sku
    });

    const savedProduct = await product.save();
    res.status(201).json(savedProduct);
  } catch (error) {
    res.status(400).json({ message: error.message });
  }
};

// Get all products
exports.getAllProducts = async (req, res) => {
  try {
    const products = await Product.find()
      .populate('category', 'name'); // Populate category name if needed
    res.json(products);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};

// Get product by ID
exports.getProductById = async (req, res) => {
  try {
    const product = await Product.findById(req.params.id)
      .populate('category', 'name');
    if (!product) return res.status(404).json({ message: 'Product not found' });
    res.json(product);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};

// Update product
exports.updateProduct = async (req, res) => {
  try {
    // If updating SKU, validate format
    if (req.body.sku && !/^[A-Za-z0-9-_]{3,}$/.test(req.body.sku)) {
      return res.status(400).json({ 
        message: "SKU must be at least 3 characters and contain only letters, numbers, hyphens and underscores" 
      });
    }

    // Check SKU uniqueness if updating to new SKU
    if (req.body.sku) {
      const existingSku = await Product.findOne({ 
        sku: req.body.sku,
        _id: { $ne: req.params.id } // Exclude current product
      });
      if (existingSku) {
        return res.status(400).json({ message: "SKU already exists" });
      }
    }

    // Generate new SKU if sku field is explicitly null/empty
    const sku = req.body.sku === null || req.body.sku === '' 
      ? await generateSKU(req.body.name)
      : req.body.sku;

    const updatedProduct = await Product.findByIdAndUpdate(
      req.params.id,
      {
        name: req.body.name,
        description: req.body.description,
        category: req.body.category,
        sku: sku
      },
      { new: true, runValidators: true }
    );

    if (!updatedProduct) return res.status(404).json({ message: 'Product not found' });
    res.json(updatedProduct);
  } catch (error) {
    res.status(400).json({ message: error.message });
  }
};

// Delete product
exports.deleteProduct = async (req, res) => {
  try {
    const product = await Product.findByIdAndDelete(req.params.id);
    if (!product) return res.status(404).json({ message: 'Product not found' });
    res.json({ message: 'Product deleted successfully' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};