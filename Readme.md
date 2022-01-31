This is a proof-of-concept of getting sales reports from payment bills in elasticsearch.

It allows you to:
- run elasticsearch + kibana locally
- index thousands of randomized payment bills
- get report data by aggregation queries
- try out your own queries in a console

# Getting started
- clone this repo
- `docker compose up`
- go to http://127.0.0.1:9000

# Screenshots
![generate payment bills](/docs/01_generate.png)

![see reports](/docs/02_reports.png)

![run queries](/docs/03_query.png)
