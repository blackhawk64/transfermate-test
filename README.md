# transfermate-test
Project for recruitment process for PHP developer position

### Project description

As described on the document, this project search would search through specifically directory for load XML files.

For making this possible, the code was prepared to have and EndPoint that could be called either by a link or another resource. This could be found in LoadInformationController at the function ReadAndLoadXml; this will return an Array with a basic report that contains the following:

> New Authors Created
> Updated Authors 
> New Books Created
> Updated Books
> Errors while creating new records 
> Errors while updating records

This function also validates some possible scenarios like:
 - Not well-formatted XML file
 - If a record (both books and authors) already exists, it will be updated and not created once again
- The possibility of having an XML record that only has an author but not a book.
- The possibility of having an XML record that only has a book but not an author
- If there is no entries, it won't loop through the array

and others...

SQL scripts included...