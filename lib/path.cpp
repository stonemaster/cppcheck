/*
 * Cppcheck - A tool for static C/C++ code analysis
 * Copyright (C) 2007-2012 Daniel Marjamäki and Cppcheck team.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

#include <algorithm>
#include <vector>
#include <sstream>
#include <cstring>
#include <cctype>
#include "path.h"

/** Is the filesystem case insensitive? */
static bool caseInsensitiveFilesystem()
{
#ifdef _WIN32
    return true;
#else
    // TODO: Non-windows filesystems might be case insensitive
    return false;
#endif
}

std::string Path::toNativeSeparators(std::string path)
{
#if defined(_WIN32)
    char separ = '/';
    char native = '\\';
#else
    char separ = '\\';
    char native = '/';
#endif
    std::replace(path.begin(), path.end(), separ, native);
    return path;
}

std::string Path::fromNativeSeparators(std::string path)
{
    char nonnative = '\\';
    char newsepar = '/';
    std::replace(path.begin(), path.end(), nonnative, newsepar);
    return path;
}

std::string Path::simplifyPath(const char *originalPath)
{
    // Skip ./ at the beginning
    if (strlen(originalPath) > 2 && originalPath[0] == '.' &&
        originalPath[1] == '/') {
        originalPath += 2;
    }

    std::string subPath = "";
    std::vector<std::string> pathParts;
    for (; *originalPath; ++originalPath) {
        if (*originalPath == '/' || *originalPath == '\\') {
            if (subPath.length() > 0) {
                pathParts.push_back(subPath);
                subPath = "";
            }

            pathParts.push_back(std::string(1 , *originalPath));
        } else
            subPath.append(1, *originalPath);
    }

    if (subPath.length() > 0)
        pathParts.push_back(subPath);

    for (unsigned int i = 1; i < pathParts.size(); ++i) {
        if (i > 1 && pathParts[i-2] != ".." && pathParts[i] == ".." && pathParts.size() > i + 1) {
            pathParts.erase(pathParts.begin() + static_cast<int>(i) + 1);
            pathParts.erase(pathParts.begin() + static_cast<int>(i));
            pathParts.erase(pathParts.begin() + static_cast<int>(i) - 1);
            pathParts.erase(pathParts.begin() + static_cast<int>(i) - 2);
            i = 0;
        } else if (i > 0 && pathParts[i] == ".") {
            pathParts.erase(pathParts.begin() + static_cast<int>(i));
            i = 0;
        } else if (i > 0 && pathParts[i] == "/" && pathParts[i-1] == "/") {
            pathParts.erase(pathParts.begin() + static_cast<int>(i) - 1);
            i = 0;
        }
    }

    std::ostringstream oss;
    for (std::vector<std::string>::size_type i = 0; i < pathParts.size(); ++i) {
        oss << pathParts[i];
    }

    return oss.str();
}

bool Path::sameFileName(const std::string &fname1, const std::string &fname2)
{
#if defined(__linux__) || defined(__sun) || defined(__hpux)
    return bool(fname1 == fname2);
#elif defined(__GNUC__)
    return bool(strcasecmp(fname1.c_str(), fname2.c_str()) == 0);
#elif defined(__BORLANDC__)
    return bool(stricmp(fname1.c_str(), fname2.c_str()) == 0);
#elif defined(_MSC_VER)
    return bool(_stricmp(fname1.c_str(), fname2.c_str()) == 0);
#else
#error Platform filename compare function needed
#endif
}

// This wrapper exists because Sun's CC does not allow a static_cast
// from extern "C" int(*)(int) to int(*)(int).
static int tolowerWrapper(int c)
{
    return std::tolower(c);
}

std::string Path::removeQuotationMarks(std::string path)
{
    path.erase(std::remove(path.begin(), path.end(), '\"'), path.end());
    return path;
}

std::string Path::getFilenameExtension(const std::string &path)
{
    const std::string::size_type dotLocation = path.find_last_of('.');
    if (dotLocation == std::string::npos)
        return "";

    std::string extension = path.substr(dotLocation);
    if (caseInsensitiveFilesystem()) {
        // on a case insensitive filesystem the case doesn't matter so
        // let's return the extension in lowercase
        std::transform(extension.begin(), extension.end(), extension.begin(), tolowerWrapper);
    }
    return extension;
}

std::string Path::getFilenameExtensionInLowerCase(const std::string &path)
{
    std::string extension = getFilenameExtension(path);
    std::transform(extension.begin(), extension.end(), extension.begin(), tolowerWrapper);
    return extension;
}

std::string Path::getRelativePath(const std::string& absolutePath, const std::vector<std::string>& basePaths)
{
    for (std::vector<std::string>::const_iterator i = basePaths.begin(); i != basePaths.end(); ++i) {
        if (absolutePath == *i || i->empty()) // Seems to be a file, or path is empty
            continue;

        bool endsWithSep = (*i)[i->length()-1] == '/';
        if (absolutePath.compare(0, i->length(), *i) == 0 && absolutePath[i->length() - (endsWithSep?1:0)] == '/') {
            std::string rest = absolutePath.substr(i->length() + (endsWithSep?0:1));
            return rest;
        }
    }
    return absolutePath;
}

bool Path::isC(const std::string &path)
{
    // In unix, ".C" is considered C++ file
    const std::string extension = getFilenameExtension(path);
    return(extension == ".c");
}

bool Path::isCPP(const std::string &path)
{
    const std::string extension = getFilenameExtensionInLowerCase(path);
    if (extension == ".cpp" ||
        extension == ".cxx" ||
        extension == ".cc" ||
        extension == ".c++" ||
        extension == ".tpp" ||
        extension == ".txx") {
        return true;
    }

    // In unix, ".C" is considered C++ file
    return(getFilenameExtension(path) == ".C");
}

bool Path::isJava(const std::string &path)
{
    const std::string extension = getFilenameExtensionInLowerCase(path);
    return(extension == ".java");
}

bool Path::isCSharp(const std::string &path)
{
    const std::string extension = getFilenameExtensionInLowerCase(path);
    return(extension == ".cs");
}

bool Path::acceptFile(const std::string &filename)
{
    return(Path::isCPP(filename) || Path::isC(filename));
}
