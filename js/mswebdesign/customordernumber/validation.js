Validation.add('validate-order-number-prefix', 'Please enter a valid prefix. For example test1-, test1 or Test.', function(v) {
    return Validation.get('IsEmpty').test(v) || /^[A-Z][A-Z0-9_\/-]*$/i.test(v)
})