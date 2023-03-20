# Utils
Add the following dependencies to your DI container:

## NetUtils
1. `GetLocalHostIpV4 => LocalHostIpV4Getter`

## Date and Time
1. `ProvideDateTime => DateTimeProvider`
2. `TransformDateTime => DateTimeTransformer`

## Files
1. `CheckDirectoryIsWriteable => DirectoryIsWriteableChecker`
2. `CheckDirectoryIsReadable => DirectoryIsReadableChecker`
3. `CheckFileExists => FileExistsChecker`
4. `EnsureFolderExists => FolderExistsEnsurer`

## Cryptography
1. `PasswordHash => HashService`
2. `PasswordVerify => HashService`
3. `GenerateStringHash => HashService`

## Email validation
1. `ValidateEmailAddress => EmailAddressValidator`

## System
1. `GetOSDescription => OsDescriptionGetter`
2. `GetPhpIntSizeConstant => PhpIntSizeConstantGetter`
3. `CalculateSigned64BitIntFromString => Signed64BitIntFromStringCalculator`
4. `CalculateSizeOfOnesComplementOfZero => SizeOfOnesComplementOfZero`
5. `CheckSystem64Bits => System64BitChecker`

## Math
1. `EqualFloats => FloatsService`
2. `CheckStringRepresentsIntegerValue => StringRepresentsIntegerValueChecker`
