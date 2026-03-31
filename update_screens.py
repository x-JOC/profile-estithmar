import re

with open('resources/views/welcome.blade.php', 'r') as f:
    content = f.read()

# I will use regular expressions to match SCREEN 2 to the end of SCREEN 3
pattern = re.compile(r'<!-- SCREEN 2: Companies -->.*?<!-- SCREEN 3: Interest Form \(Sana\) -->', re.DOTALL)
content = re.sub(pattern, '<!-- NEW SCREENS BLOCK -->', content)

# I also need to replace the old Screen 3 block up to the closing tags
pattern2 = re.compile(r'<!-- NEW SCREENS BLOCK -->.*?(</div>\n\n    </div>\n\n    <script>)', re.DOTALL)
# Wait, let's just find the start of SCREEN 2, and the start of <script> and replace everything in between.
# Let's do it cleanly!
