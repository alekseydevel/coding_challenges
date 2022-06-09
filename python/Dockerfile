FROM python:3.7-alpine

RUN mkdir /app
WORKDIR /app

ADD ./requirements.txt /app
ADD ./main.py /app
ADD ./app /app/app

RUN pip3 install -r requirements.txt

CMD ["gunicorn", "-w 1", "-b", "0.0.0.0:8000", "main:app"]