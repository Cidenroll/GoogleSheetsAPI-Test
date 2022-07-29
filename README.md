# GoogleSheets-Test

Hello!

I have made this application to test out the GoogleSheets API functionality. The main feature used in this small project is the Symfony Console component. This is used in the roots' application.php script. 
The autowiring of services is done via the PSR11 DI container, defined in the src/Domain/Container folder. 
The application code is found in the 'src' directory. The code is structured in a hexagonal architype structure, having:
1. an Application layer (mostly Controllers are here), 
2. a Domain layer (Entities and bussiness logic Services lie here)
3. the Port layer, containing some common library classes and the explicit Repository classes
4. the Middleware layer, having connectors to the database, GoogleSheetsAPI and Remote FTP connector

The symfony console command for running the read/upload of the file to GoogleSheets is:
[bash in pu-php] `php application.php gs:upload -f filename.extension -l remote/local`

The local/remote parameters has it's address configured in the .env file:
    1. for local -> LOCAL_URL = is the directory where the xml file is uploaded (ex: app/to_upload)
    2. for remote -> REMOTE_URL + REMOTE_DIR + REMOTE_CRED_USER + REMOTE_CRED_PASS

Flow of the command:\
    1. Command calls the UploadController. \
    2. UploadController uses UploadSheetService to uploadSheet()\
    3. uploadSheet() determines the type of sheet so it will branch out sheet parse logic\
    4. the createSheet() will actually create+update the sheet with file information via GoogleSheetsAPI and will return an asset \
    5. this asset is used afterwards to populate an entry in the database with the sheet information (random id - if successful or error message if fail)
    6. if there are errors found along the way, the try-catch will catch the exceptions and logs them in /logs/errors.log
    
Patterns used: factory:
        -> to determine what kind of sheet is used (local or remote) using the SheetInterface to be implemented in LocalSheet and RemoteSheet
        -> to determine what parsing logic should be used, having a UploaderFactory extended by LocalUploader and RemoteUploader  and used in \Src\Domain\Service\UploadSheetService::uploadSheet altogether
        
Other observations:
    - DRY, used KISS, used Abstraction (where i thought it was needed)
    - using SonarLint to detect on-the-fly code inconsistencies
    - used SOLID 
        - examples:
            - single responsibility = \Src\Port\Repositories\WriteHistoryRepository only writes in the db
            - open/closed = did not use singletons, as they defeat this principle
            - liskov sub = SheetInterface implemented in LocalSheet and RemoteSheet
            - interface segregation = did not over-complicate interfaces
            - dependency inversion = UploadController calls the needed service once to upload() > this service calls services where needed only, and so on\ 

Unit-tests:
    - phpunit tests are available at app/tests
    - also code coverage is available by [bash in pu-php] './vendor/bin/phpunit tests --coverage-html coverage.html/'
    - other tools used: xdebug      
