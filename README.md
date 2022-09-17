### API for frontend development

1. Customer eligible check
   ○ Check the customer eligibility requirement.
   ○ If qualified, lockdown a voucher for 10 minutes to this customer.
2. Validate photo submission
   ○ Call the image recognition API to validate the photo submission qualification. (Please faking this process for now, you do not need to create the image recognition API)
   ○ If the image recognition result return is true and the submission within 10 minutes, allocate the locked voucher to the customer and return the voucher code.
   ○ If the result return is false or submission exceeds 10 minutes, remove the lock down and this voucher will become available to the next customer to grab.

### Included

```
1.Laravel project files
2.Mysql
3.Readme
4.API Document
5.Logic Process
```

### Required

```
1.PHP Version 8.1.10
2.Laravel Version 9.30.0
3.MySql/MariaDb
```

### End Points

```
1.http://127.0.0.1:8000/api/v1/vouchers/{customerId}
2.http://127.0.0.1:8000/api/v1/redeemvouchers
```
