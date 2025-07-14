function isValidVariable(variable)
{
    if (variable == null || variable == undefined || variable == '0' || variable == '' || variable == ' ')
    {
        return false;
    } else
    {
        return true;
    }
}