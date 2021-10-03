# Lead processor

Use docker for run.

Create docker image file:

```bash
docker build  -t IMAGE_NAME .
```


Start processing in docker container:

```bash
docker run -v "$(pwd)\Logs:/usr/src/LeadProcessor/Logs" -it --rm --name running-lead-processor IMAGE_NAME
```
