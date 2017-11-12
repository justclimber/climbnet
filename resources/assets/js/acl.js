exports.aclRules = function(acl) {
    acl.rule('view', 'MyClimbs');
    acl.rule('create', 'Climb');
};