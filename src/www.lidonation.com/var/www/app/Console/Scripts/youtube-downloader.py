from pytube import YouTube
import sys



# Get the number of arguments (excluding the script name)
num_args = len(sys.argv) - 1

# Check if the correct number of arguments is provided
if num_args != 3:
    print("Usage: python youtube-downloader.py string:video_url string:output_path string:filename")
    sys.exit(1)

video_url = sys.argv[1] # videos url
output_path = sys.argv[2] # the directory to store the video
custom_filename = sys.argv[3] #actual video filename


# Replace this URL with the YouTube video URL you want to download
video_url = "https://www.youtube.com/watch?v=pn0wynLO5G8"

# Create a YouTube object
yt = YouTube(video_url)

# Select the stream with the desired resolution and format
# You can customize this part according to your preference
stream = yt.streams.filter(res="360p", file_extension="mp4").first()



# Download the video with the custom filename
stream.download(output_path=output_path, filename=custom_filename)
