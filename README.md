# Utils
Add the following dependencies to your DI container:

## NetUtils
1. `GetLocalHostIpV4 -> LocalHostIpV4Getter`

## Date and Time
1. `ProvideDateTime -> DateTimeProvider`
2. `TransformDateTime -> DateTimeTransformer`

## Files
1. `CheckDirectoryIsWriteable -> DirectoryIsWriteableChecker`

## Cryptography
1. `PasswordHash -> HashService`
2. `PasswordVerify -> HashService`
3. `GenerateRandomStringToken -> RandomStringTokenGenerator`

## Email validation
1. `ValidateEmailAddress -> EmailAddressValidator`
